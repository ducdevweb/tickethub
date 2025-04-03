<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function ShowCart()
    {
        $userId = Auth::check() ? Auth::user()->id : 0; 
        $carts = Cart::with(['ticket'])->where("id_user", $userId)->get();
        return view("user.cart.cart", compact("carts"));
    }

    public function addCart(Request $request, $id_ticket)
    {
        $quantity = $request->input("quantity_detail", 1);
        $this->cartService->addToCart($id_ticket, $quantity);
        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }
    public function updateQuantity(Request $request, $id_cart)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để cập nhật giỏ hàng!'
                ], 401);
            }
    
            $newQuantity = $request->input('update_cart');
            $response = $this->cartService->updateCartQuantity($id_cart, $newQuantity);
            return $response; 
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function delCart($id_cart)
    {
        $this->cartService->delCart($id_cart);
        return $this->successRedirect('cart', 'Xóa sản phẩm khỏi giỏ hàng thành công!');
    }
}