<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Bank;
use App\Models\Cart;
use App\Models\Bouquet; 
use App\Models\Category;
use App\Models\UserAddress;
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

        $user = Auth::user();
$userAddress = $user->address;
        return view('front.checkout', compact('bouquet', 'data', 'banks', 'categories', 'userAddress'));
    }

    // FrontController.php
public function cartCheckout()
{
    $categories = Category::all();
    $banks = Bank::all();
    $user = Auth::user();
    $userAddress = $user->address;
    $cartItems = Cart::where('user_id', $user->id)->get();

    return view('front.cartCheckout', compact('cartItems', 'banks', 'categories', 'userAddress', 'user'));
}


public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:6|confirmed',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'post_code' => 'required|string|max:255',
    ]);

    $user = auth()->user();
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    // Simpan atau update alamat
    UserAddress::updateOrCreate(
        ['user_id' => $user->id],
        [
            'address' => $request->address,
            'city' => $request->city,
            'post_code' => $request->post_code,
        ]
    );

    return back()->with('success', 'Profil berhasil diperbarui.');
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
        'note' => 'nullable|string|max:1000',
        'quantity' => 'required|integer|min:1',
    ]);

    $user = Auth::user();
    $userAddress = $user->address;

    if (!$userAddress) {
        return redirect()->route('profile.edit')->withErrors(['address' => 'Alamat belum diisi. Silakan lengkapi di halaman profil.']);
    }

    $cartItems = Cart::where('user_id', $user->id)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('front.cart')->withErrors('Keranjang kamu kosong.');
    }

    $grandTotal = $cartItems->sum(fn($item) => $item->bouquet->price * $item->quantity);

    $uniqueTrxId = BouquetTransaction::generateUniqueTrxId();

    $transaction = BouquetTransaction::create([
        'user_id' => $user->id,
        'address' => $userAddress->address,
        'city' => $userAddress->city,
        'post_code' => $userAddress->post_code,
        'sub_total_amount' => $grandTotal,
        'grand_total_amount' => $grandTotal,
        'bank_id' => $request->bank_id,
        'is_paid' => false,
        'transaction_trx_id' => $uniqueTrxId,
        'proof' => 'proof.png',
        'status' => 'unpaid',
        'note' => $request->note ?? '',
    ]);

    foreach ($cartItems as $item) {
        $transaction->items()->create([
            'bouquet_id' => $item->bouquet_id,
            'quantity' => $item->quantity,
            'sub_total_amount' => $item->bouquet->price * $item->quantity,
        ]);
    }

    Cart::where('user_id', $user->id)->delete();

    return redirect()->route('front.payment', $uniqueTrxId)
        ->with('success', 'Pesanan berhasil dibuat!');
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
