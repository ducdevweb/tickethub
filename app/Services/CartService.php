<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CartService
{
    private function calculateFinalPrice(Ticket $ticket)
    {
        return $ticket->sale_ticket > 0 ? $ticket->sale_ticket : $ticket->price_ticket;
    }

    public function addToCart($id_ticket, $quantity = 1)
    {
        try {
            $ticket = Ticket::findOrFail($id_ticket);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Vé không tồn tại!'], 404);
        }
    
        $finalPrice = $this->calculateFinalPrice($ticket);
        $userId = Auth::check() ? Auth::id() : 0;
    
        $cart = Cart::where('id_ticket', $ticket->id_ticket)
                    ->where('id_user', $userId)
                    ->first();
    
        if ($cart) {
            $cart->quantity_cart += $quantity;
        } else {
            $cart = new Cart();
            $cart->id_ticket = $ticket->id_ticket;
            $cart->quantity_cart = $quantity;
            $cart->id_user = $userId;
        }
    
        $cart->total_cart = $cart->quantity_cart * $finalPrice;
        $cart->save();
    
        return response()->json(['success' => true, 'message' => 'Thêm vào giỏ hàng thành công!']);
    }
    
    public function updateCartQuantity($id_cart, $newQuantity)
    {
        $cart = Cart::with('ticket')->find($id_cart);
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'], 404);
        }
    
        if (!$cart->ticket) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không hợp lệ!'], 400);
        }
    
        if ($newQuantity > $cart->ticket->quantity_ticket) {
            return response()->json(['success' => false, 'message' => 'Số lượng vé không đủ!'], 400);
        }
    
        $newQuantity = max(1, $newQuantity);
        $cart->quantity_cart = $newQuantity;
        $cart->total_cart = $newQuantity * ($cart->ticket->sale_ticket > 0 ? $cart->ticket->sale_ticket : $cart->ticket->price_ticket);
        $cart->save();
    
        $cartTotal = Cart::where('id_user', Auth::user()->id)->sum('total_cart');
    
        return response()->json([
            'success' => true,
            'new_quantity' => $cart->quantity_cart, // Số lượng mới
            'new_total' => number_format($cart->total_cart, 0, ',', '.') . ' đ', // Chuỗi định dạng
            'raw_total' => $cart->total_cart, // Giá trị số
            'cart_total' => number_format($cartTotal, 0, ',', '.') . ' đ' // Tổng tiền giỏ hàng
        ]);
    }
    
    

    public function delCart($id_cart)
    {
        $cart = Cart::find($id_cart);
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm!'], 404);
        }
        $cart->delete();
        return response()->json(['success' => true, 'message' => 'Xóa sản phẩm thành công!']);
    }
    
}