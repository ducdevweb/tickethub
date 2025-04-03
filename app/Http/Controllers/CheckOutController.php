<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * 
     */
    public function ShowCheckOut(Request $request)
    {
        try {
            $selectedCarts = explode(',', $request->query('selected_carts', ''));
            if (empty($selectedCarts)) {
                return redirect()->route('cart')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
            }

            $userId = Auth::id();
            $checkouts = Cart::with(['ticket'])
                             ->where('id_user', $userId)
                             ->whereIn('id_cart', $selectedCarts)
                             ->get();
    
            if ($checkouts->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Không tìm thấy sản phẩm nào trong giỏ hàng!');
            }
    
            return view("user.checkout.checkout", compact("checkouts"));
    
        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', $e->getMessage());
        }
    }
    

    /**
     * 
     */
    public function process(Request $request)
    {
        try {
            $result = $this->checkoutService->PushCheckOut($request);

            if (is_array($result) && isset($result['payment_url'])) {
                return redirect($result['payment_url']);
            }

            return redirect()->route('thank-you')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * 
     */
    public function callback(Request $request)
    {
        $vnp_HashSecret = "P5W2FYJFDI1LL1YYLHQRXGP1I2FDYA53";
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            $orderId = $inputData['vnp_TxnRef'] ?? '';
            $order = Order::find($orderId);

            if (!$order) {
             return $this->errorRedirect('checkout', 'Đơn hàng không tồn tại!');
            }

            if ($inputData['vnp_ResponseCode'] == '00' ) {
                $order->status='Đã thanh toán';
                $order->save();
                return $this->successRedirect('thank-you', 'Thanh toán thành công!');
            } else {
                if ($order->status == 'Chờ thanh toán') {
                    DB::transaction(function () use ($orderId, $order) {
                        DetailOrder::where('id_order', $orderId)->delete();
                        $order->delete();
                    });
                }
                return $this->errorRedirect('checkout', 'Thanh toán thất bại!');
            }
        } else {
            return $this->errorRedirect('checkout', 'Chữ ký không hợp lệ!');
        }
    }
    public function thankYou()
    {
        return view('user.checkout.thank');
    }
}