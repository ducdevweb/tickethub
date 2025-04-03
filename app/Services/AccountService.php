<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\DetailOrder;
use App\Models\Favourite;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountService
{

    public function getBooking() {}
    public function getOrder()
    {
        $id = Auth::user()->id;
        $order = Order::with('detailOrders')->where('id_user', $id)->get();
        return $order;
    }
    public function listDetailOrder($id_order)
    {
        $detaiOrders = DetailOrder::with('ticket', 'order')->where('id_order', $id_order)->get();
        return $detaiOrders;
    }
    public function getCommentUser()
    {
        $id = Auth::user()->id;
        $commentUser = Comment::with('user', 'ticket')->where('id_user', $id)->get();
        return $commentUser;
    }
    public function getFavourite()
    {
        $id = Auth::user()->id;
        $favorite = Favourite::with('ticket')->where('id_user', $id)->get();
        return $favorite;
    }
    public function updateUser(Request $request)
    {
        $currentUser = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $currentUser->id,
            'phone' => 'nullable|string|unique:users,phone,' . $currentUser->id,
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:3|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($currentUser->id);
        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng để cập nhật.');
        }
        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->file('img')->extension();
            $oldImage = $user->img;
            $request->file('img')->move(public_path('uploads'), $imageName);
            $user->img = 'uploads/' . $imageName;
            if ($oldImage && file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone') ?? null;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
       return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }
}
