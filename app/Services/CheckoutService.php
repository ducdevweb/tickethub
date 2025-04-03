<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutService
{
    /**
     * Lấy danh sách sản phẩm đã chọn để thanh toán
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function GetCheckOut(Request $request)
    {
        $userId = Auth::id() ?? 0;
        $selectedCarts = $request->input('selected_carts', []);

        if (empty($selectedCarts)) {
            throw new \Exception('Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
        }

        $checkouts = Cart::with(['ticket', 'event'])
            ->where('id_user', $userId)
            ->whereIn('id_cart', $selectedCarts)
            ->get();

        if ($checkouts->isEmpty()) {
            throw new \Exception('Không tìm thấy sản phẩm nào trong giỏ hàng!');
        }

        return $checkouts;
    }

    /**
     * 
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Order
     * @throws \Exception
     */
    public function PushCheckOut(Request $request)
    {
        $userId = Auth::id() ?? 0;
        $selectedCarts = $request->input('selected_carts', []);
    
        if (empty($selectedCarts)) {
            throw new \Exception('Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
        }
    
        $checkouts = Cart::with('ticket')
                        ->where('id_user', $userId)
                        ->whereIn('id_cart', $selectedCarts)
                        ->get();
    
        if ($checkouts->isEmpty()) {
            throw new \Exception('Giỏ hàng của bạn trống hoặc không có sản phẩm nào được chọn!');
        }
    
        $validated = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'payment' => 'nullable|string|in:bank,cod',
        ]);
    
        return DB::transaction(function () use ($userId, $checkouts, $validated, $selectedCarts) {
            $totalOrder = $checkouts->sum(function ($checkout) {
                return ($checkout->ticket->sale_ticket > 0 ? $checkout->ticket->sale_ticket : $checkout->ticket->price_ticket) * $checkout->quantity_cart;
            });
    
            $order = new Order();
            $order->id_user = $userId;
            $order->status = 'Chờ thanh toán';
            $order->email = $validated['email'];
            $order->name = $validated['first_name'] . ' ' . $validated['last_name'];
            $order->address = $validated['address'] . ' ' . $validated['district'] . ' ' . $validated['city'];
            $order->phone = $validated['phone'];
            $order->save();
    
            foreach ($checkouts as $checkout) {
                $ticket = Ticket::where('id_ticket', $checkout->id_ticket)->first();
    
                if (!$ticket) {
                  return redirect()->route('cart')->with('error', 'Vé không tồn tại');
                }
                if ($ticket->quantity_ticket < $checkout->quantity_cart) {
                 return redirect()->route('cart')->with('error', 'Số lượng vé không đủ');
                }
    
                $price = $ticket->sale_ticket > 0 ? $ticket->sale_ticket : $ticket->price_ticket;
    
                for ($i = 0; $i < $checkout->quantity_cart; $i++) {
                    DetailOrder::create([
                        'id_order' => $order->id_order,
                        'id_event'=>$ticket->id_event,
                        'id_ticket' => $ticket->id_ticket,
                        'seri_ticket' => strtoupper(Str::random(10)),
                        'total' => $price,
                        'quantity' => 1, 
                    ]);
                }
                $ticket->decrement('quantity_ticket', $checkout->quantity_cart);
                if ($ticket->quantity_ticket <= 0) {
                    $ticket->update(['is_hidden' => 1]);
                }
                $ticket->increment('bought',$checkout->quantity_cart);
                if ($ticket->id_event) {
                    Event::where('id_event', $ticket->id_event)
                         ->increment('sold_ticket', $checkout->quantity_cart);
                }
            }
            Cart::where('id_user', $userId)->whereIn('id_cart', $selectedCarts)->delete();
            $vnpayUrl = $this->createVNPayPayment($order, $totalOrder);
            Mail::to($order->email)->send(new \App\Mail\OrderConfirmation($order, $checkouts, $vnpayUrl));
            return ['order' => $order, 'payment_url' => $vnpayUrl];
        }, 5);
    }
    
    
    
    private function createVNPayPayment(Order $order, $totalOrder)
    {
        $vnp_TmnCode = "56F4FNRW";
        $vnp_HashSecret = "P5W2FYJFDI1LL1YYLHQRXGP1I2FDYA53"; 
        
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('checkout.callback');

        $vnp_TxnRef = $order->id_order;
        $vnp_OrderInfo = "Thanh toán đơn hàng #{$order->id_order}";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $totalOrder * 100;
        $vnp_Locale = "vn";
        $vnp_IpAddr = request()->ip();
        $vnp_CreateDate = date('YmdHis');

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $hashdata = $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;
        Log::info('VNPay URL Input Data: ', $inputData);
        return $vnp_Url;
    }
}
