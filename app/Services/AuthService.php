<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function login($email, $password)
    {
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function checkRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|unique:users,phone',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('uploads'), $imageName);
        } else {
            $imageName = 'default-avatar.jpg';
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'img' => $imageName,
            'status' => 1,
        ]);

        Auth::login($user);
        return true;
    }
     
   
    public function storeComment(Request $request) {
        $validated = $request->validate([
            'id_ticket' => 'required|exists:ticket,id_ticket',
            'star' => 'required|integer|min:1|max:5',
            'text' => 'required|string|max:1000',
        ]);
        $validated['id_user'] = Auth::id();
        Comment::create($validated);
        return redirect()->back()->with('success', 'Bình luận thành công!');
    }
    

    public function handleGoogleCallback(): bool
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(uniqid()),
                    'img' => $googleUser->avatar ?? 'default-avatar.jpg',
                    'phone' => null,
                    'status' => 1,
                ]
            );

            Auth::login($user);
            return true;
        } catch (Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            throw $e;
        }
    }
}