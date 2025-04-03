<?php

namespace App\Exports;

use App\Models\DetailOrder;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderDetailExport implements FromArray, WithHeadings
{
    protected $orders;

    public function __construct($id)
    {
        $this->orders = DetailOrder::with('order.user', 'ticket.event')
            ->where('id_order', $id) 
            ->get();
    }
    public function array(): array
    {
        if ($this->orders->isEmpty()) {
            return [];
        }
    
        $data = [];
    
        foreach ($this->orders as $order) {
            $data[] = [
                'ID Đơn Hàng' => $order->id_detail,
                'Sự Kiện' => $order->event->name_event ?? 'N/A',
                'Loại Vé' => $order->ticket->ticket_type ?? 'N/A',
                'Số Seri' => $order->seri_ticket ?? 'N/A',
                'Số Lượng' => $order->quantity ?? 0,
                'Thành Tiền (VNĐ)' => number_format($order->total, 0, ',', '.'),
                'Ngày Giao Dịch' => $order->created_at->format('d/m/Y H:i'),
                'Trạng Thái' => $order->order->status ?? 'N/A',
            ];
        }
    
        return $data;
    }
    

    public function headings(): array
    {
        return [
            'ID Đơn Hàng',
            'Sự Kiện',
            'Loại Vé',
            'Số Seri',
            'Số Lượng',
            'Thành Tiền (VNĐ)',
            'Ngày Giao Dịch',
            'Trạng Thái',
        ];
    }
}
