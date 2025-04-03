<?php

namespace App\Exports;

use App\Models\DetailOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RevenueDetailExport implements FromCollection, WithHeadings, WithMapping
{
    protected $id_event;

    public function __construct($id_event)
    {
        $this->id_event = $id_event;
    }

    public function collection()
    {
        return DetailOrder::with('ticket','order.user')->where('id_event', $this->id_event)->get();
    }

    public function map($detail): array
    {
        return [
            $detail->seri_ticket ?? 'N/A',
            $detail->ticket->type_ticket ?? 'N/A', 
            $detail->order->user->name ?? 'N/A',  
            $detail->created_at ? $detail->created_at->format('d/m/Y') : 'N/A',
            (float)$detail->total ?? 0, 
        ];
    }

    public function headings(): array
    {
        return [
            'Seri Vé',
            'Loại Vé',
            'Khách Hàng',
            'Ngày Đặt',
            'Giá Vé (VNĐ)',
        ];
    }
}
