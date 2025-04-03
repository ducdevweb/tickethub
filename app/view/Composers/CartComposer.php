<?php

namespace App\View\Composers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    public function compose(View $view)
    {
        $userId = Auth::id() ?? 0;
        $carts = Cart::with('ticket')->where('id_user', $userId)->get();
        $total = $carts->sum('total_cart'); 
        $quantity=$carts->sum('quantity_cart');
        $view->with('quantity', $quantity);
        $view->with('carts', $carts);
        $view->with('total', $total);
    }
}