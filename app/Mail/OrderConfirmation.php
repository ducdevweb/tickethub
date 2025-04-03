<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $checkouts;

    public $vnpayUrl;
    public function __construct(Order $order, $checkouts, $paymentUrl)
    {
        $this->order = $order;
        $this->checkouts = $checkouts;
        $this->vnpayUrl;
    }

    public function build()
    {
        return $this->subject('Xác nhận đơn hàng #' . $this->order->id_order)
                    ->view('user.checkout.order_confirmation')
                    ->with([
                        'order' => $this->order,
                        'checkouts' => $this->checkouts,
                        'vnpayUrl' => $this->vnpayUrl,
                    ]);
    }
}