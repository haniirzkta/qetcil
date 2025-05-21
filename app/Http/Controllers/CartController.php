<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Bouquet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $cartItems = Cart::where('user_id', Auth::id())->with('bouquet')->get();
        // $latestPhotos = $packageTour->package_photos()->orderByDesc('id')->take(3)->get();
        // $cartItems = $cart->jewelries()->orderByDesc('id')->get();
        // sweet alert confirmation
        // $title = 'Delete Bouquet!';
        // $text = "Are you sure you want to delete?";
        // confirmDelete($title, $text);

        return view('front.cart', compact('categories', 'cartItems'));
    }

    public function cartAdd(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'bouquet_id' => 'required|exists:jewelries,id', // Pastikan jewelry_id ada di tabel jewelries
            'quantity' => 'required|integer|min:1',        // Pastikan quantity adalah integer dan lebih dari 0
            'size' => 'required|integer'
        ]);

        // Mulai transaksi untuk memastikan integritas data
        DB::transaction(function () use ($request) {
            $userId = Auth::id(); // Ambil ID user yang sedang login
            $bouquetId = $request->bouquet_id;
            $quantity = $request->quantity;

            // Ambil data perhiasan untuk menghitung harga
            $bouquet = Bouquet::findOrFail($bouquetId);

            // Cari item di keranjang user saat ini
            $cartItem = Cart::where('user_id', $userId)
                ->where('bouquet_id', $bouquetId)
                ->first();

            if ($cartItem) {
                // Jika item sudah ada, tambahkan quantity
                $cartItem->quantity += $quantity;
                $cartItem->total_price = $cartItem->quantity * $bouquet->price;
                // Hitung grand total untuk semua item di keranjang user
                $grandTotalPrice = Cart::where('user_id', $userId)
                    ->sum('total_price');

                $cartItem->save();
            } else {
                // Jika item belum ada, buat data baru
                Cart::create([
                    'user_id' => $userId,
                    'bouquet_id' => $bouquetId,
                    'size' => $size,
                    'quantity' => $quantity,
                    'total_price' => $bouquet->price * $quantity,
                    'grand_total_price' => $bouquet->price * $quantity,
                ]);
            }
        });

        toast()
            ->success('Success! Your Dream Jewelry Awaits 💎', 'Head over to your cart and make it yours today!');
        return redirect()->back();
    }

    public function addQuantity(Bouquet $bouquet)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('user_id', $userId)
            ->where('bouquet_id', $bouquet->id)
            ->first();

        if ($cartItem) {
            DB::transaction(function () use ($cartItem, $bouquet) {
                $cartItem->quantity += 1;
                $cartItem->total_price = $cartItem->quantity * $bouquet->price;
                $cartItem->save();
            });
        }

        return redirect()->route('cart.index');
    }

    public function removeQuantity(Bouquet $bouquet)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('user_id', $userId)
            ->where('bouquet_id', $bouquet->id)
            ->first();

        if ($cartItem && $cartItem->quantity > 1) {
            DB::transaction(function () use ($cartItem, $bouquet) {
                $cartItem->quantity -= 1;
                $cartItem->total_price = $cartItem->quantity * $bouquet->price;
                $cartItem->save();
            });
        }

        return redirect()->route('cart.index');
    }
}
