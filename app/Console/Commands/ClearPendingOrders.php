<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ClearPendingOrders extends Command
{
    protected $signature = 'orders:clear-pending';
    protected $description = 'Xóa đơn hàng "Chờ Thanh Toán" nếu quá 15 phút chưa thanh toán.';

    public function handle()
    {
        $expiredTime = now()->subMinutes(1); 

        $orders = Order::where('status', 'Chờ Thanh Toán')
            ->where('created_at', '<', $expiredTime)
            ->get();

        foreach ($orders as $order) {
            $details = DetailOrder::where('id_order', $order->id_order)->get();

            foreach ($details as $detail) {
                $ticket = Ticket::with('event')->where('id_ticket', $detail->id_ticket)->first();

                if ($ticket) {
                    $ticket->increment('quantity_ticket', $detail->quantity);
                    $ticket->decrement('bought', $detail->quantity);
                    $event = $ticket->event;
                    if ($event) {
                        $event->decrement('sold_ticket', $detail->quantity);
                    }
                }
                $detail->delete(); 
            }
            
            $order->delete(); 
            Log::info("🗑️ Đã xóa đơn hàng #{$order->id_order} do quá hạn thanh toán.");
        }

        $this->info(count($orders) . ' đơn hàng đã bị xóa.');
    }
}
