<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Cart;
use App\Models\Bouquet; 
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\BouquetTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('front.index', compact('categories'));
    }

    public function category(Category $category)
{
    $categories = Category::all();
    $category->load('bouquets');
    return view('front.bouquet', compact('category', 'categories'));
}


    public function detail(Category $category, Bouquet $bouquet)
    {
        $categories = Category::all();
        
        $bouquet = Bouquet::with('bouquetPhotos')->where('id', $bouquet->id)->get();
        return view('front.detail', compact('category', 'categories', 'bouquet'));
    }

    public function checkout(Request $data)
    {
        // dd($data);
        $data->validate([
            'bouquet_id' => 'required|exists:bouquets,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $categories = Category::all();
        $banks = Bank::all();
        $bouquet = Bouquet::findOrFail($data->bouquet_id);

        return view('front.checkout', compact('bouquet', 'data', 'banks', 'categories'));
    }

    public function cartCheckout()
    {
        $categories = Category::all();
        $banks = Bank::all();
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();

        return view('front.cartCheckout', compact('cartItems', 'banks', 'categories'));
    }

    public function checkoutProcess(Bouquet $bouquet, Request $request)
    {
        $request->validate([
            'bouquet_id' => 'required|exists:bouquets,id',
            'quantity' => 'required|integer|min:1',
            'bank_id' => 'required|exists:banks,id',
        ]);

        $bouquet = Bouquet::where('id', $request->bouquet_id)->firstOrFail();

        $uniqueTrxId = BouquetTransaction::generateUniqueTrxId();
        $sub_total = $bouquet->price * $request['quantity'];

        // Create new transaction
        $transaction = BouquetTransaction::create([
            'user_id' => Auth::id(),
            'bouquet_id' => $request->bouquet_id,
            'quantity' => $request->quantity,
            'sub_total_amount' => $sub_total,
            'grand_total_amount' => $sub_total,
            'bank_id' => $request->bank_id,
            'is_paid' => false,
            'transaction_trx_id' => $uniqueTrxId,
            'proof' => 'proof.png',
            'status' => 'unpaid',
        ]);

        return redirect()->route('front.payment', $uniqueTrxId);
    }

    public function cartCheckoutProcess(Request $request)
    {
        $request->validate([
            'bank_id' => 'required|exists:banks,id',
        ]);

        $user = Auth::user();
        // dd($user->id);
        $cartItems = Cart::where('user_id', $user->id)->get();
        // dd($cartItems);

        if ($cartItems->isEmpty()) {
            return redirect()->route('front.cart')->withErrors('Your cart is empty!');
        }

        $grandTotal = 0;
        foreach ($cartItems as $item) {
            $grandTotal += $item->bouquet->price * $item->quantity;
        }

        $uniqueTrxId = BouquetTransaction::generateUniqueTrxId();

        $transaction = BouquetTransaction::create([
            'user_id' => $user->id,
            'sub_total_amount' => $grandTotal,
            'grand_total_amount' => $grandTotal,
            'bank_id' => $request->bank_id,
            'is_paid' => false,
            'transaction_trx_id' => $uniqueTrxId,
            'proof' => 'proof.png',
            'status' => 'unpaid',
        ]);


        foreach ($cartItems as $item) {
            $transaction->items()->create([
                'bouquet_id' => $item->bouquet_id,
                'quantity' => $item->quantity,
                'sub_total_amount' => $item->bouquet->price * $item->quantity,
            ]);
        }

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('front.payment', $uniqueTrxId);
    }

    public function payment($uniqueTrxId)
    {
        $transaction = BouquetTransaction::where('transaction_trx_id', $uniqueTrxId)->with('bank')->firstOrFail();

        return view('front.payment', compact('transaction'));
    }

    public function paymentStore($uniqueTrxId, Request $request)
    {
        $transaction = BouquetTransaction::where('transaction_trx_id', $uniqueTrxId)->firstOrFail();

        $user = Auth::user();
        if ($transaction->user_id != $user->id) {
            abort(403);
        }

        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $filePath = $file->store('proofs', 'public');
            $transaction->update(['proof' => $filePath]);
            $transaction->update(['is_paid' => false, 'status' => 'checking']); // Set the status to "in delivery" after payment is received
        }

        return redirect()->route('front.paymentSuccess', $uniqueTrxId);
    }

    public function paymentSuccess()
    {
        return view('front.paymentSuccess');
    }
}
