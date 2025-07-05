<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use App\Models\BouquetTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Show the edit profile form
    public function edit()
    {
        $user = Auth::user();
        $categories = Category::all();
        $transactions = BouquetTransaction::where('user_id', $user->id)->orderByDesc('created_at')->get();
        return view('front.profile', compact('user', 'transactions','categories'));
    }

    public function setting() {
        $categories = Category::all();
        return view('front.setting', compact('categories', ));
    }

    // Update the user's profile
    public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:8',

        'phone_number' => 'nullable|string|max:20',

        // Alamat
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'post_code' => 'required|string|max:20',
    ]);

    // Update data user
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->phone_number = $validated['phone_number'];

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    // Update atau buat alamat
    $user->address()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'address' => $validated['address'],
            'city' => $validated['city'],
            'post_code' => $validated['post_code'],
        ]
    );

    return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
}



    public function transactions() {
        $categories = Category::all();
        $transactions = BouquetTransaction::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('front.transactions', compact('transactions','categories'));

    }

    public function logout(Request $request) {
        Filament::auth()->logout();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('front.index');
    }
}