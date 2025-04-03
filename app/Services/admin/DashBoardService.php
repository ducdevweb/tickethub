<?php

namespace App\Services\admin;

use App\Exports\OrderDetailExport;
use App\Exports\RevenueDetailExport;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DashBoardService
{
    public function getDashBoard()
    {
        return [
            "count_order"   => DetailOrder::count(),
            "revenue_order" => DetailOrder::sum('total'),
            "count_event"   => Event::count(),
            "count_user"    => User::count(),
            "new_ticket"    => DetailOrder::with(['ticket.event', 'order'])
                ->latest()
                ->limit(5)
                ->get()
        ];
    }
    public function getTickets($filters)
    {
        $query = Ticket::with(['event', 'cate']);

        if (!empty($filters['search'])) {
            $query->where('name_ticket', 'LIKE', "%{$filters['search']}%");
        }

        if (!empty($filters['id_event'])) {
            $query->where('id_event', $filters['id_event']);
        }

        if (!empty($filters['id_cate'])) {
            $query->where('id_cate', $filters['id_cate']);
        }

        if (!empty($filters['quantity'])) {
            $query->orderBy('quantity_ticket', $filters['quantity']);
        }

        if (!empty($filters['price'])) {
            $query->orderBy('price_ticket', $filters['price']);
        }

        return $query->paginate(10)->appends($filters);
    }

        public function getDashEvent($filters)
        {
            $listEvent = Event::with('ticket');

            if (!empty($filters['search'])) {
                $listEvent->where('name_event', 'LIKE', '%' . $filters['search'] . '%');
            }
            if (!empty($filters['status'])) {
                $listEvent->where('status', $filters['status']);
            }

            if (!empty($filters['date_start'])) {
                $listEvent->whereDate('date_start', '>=', $filters['date_start']);
            }

            if (!empty($filters['date_end'])) {
                $listEvent->whereDate('date_end', '<=', $filters['date_end']);
            }

            return [
                'event' => $listEvent->paginate(10)->appends($filters),
                'count_event' => Event::count()
            ];
        }

    public function getDashUser($filters)
    {
        $query = User::query();

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%$searchTerm%")
                    ->orWhere('email', 'LIKE', "%$searchTerm%")
                    ->orWhere('phone', 'LIKE', "%$searchTerm%");
            });
        }

        return $query->orderBy('id', 'ASC')->paginate(7)->appends($filters);
    }

    public function getDashRevenue($filters)
    {
        $revenue = DetailOrder::sum('total');
        $ticket_sold = DetailOrder::sum('quantity');
        $average_revenue = $ticket_sold ? $revenue / $ticket_sold : 0;
        $events=Event::with('detailOrder');
        if (!empty($filters['event'])) {
            if ($filters['event'] === 'desc') {
                $events->orderBy('sold_ticket', 'DESC');
            } elseif ($filters['event'] === 'asc') {
                $events->orderBy('sold_ticket', 'ASC');
            }
        }
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $events->whereBetween('date_start', [$filters['start_date'], $filters['end_date']]);
        } elseif (!empty($filters['start_date'])) {
            $events->where('date_start', '>=', $filters['start_date']);
        } elseif (!empty($filters['end_date'])) {
            $events->where('date_start', '<=', $filters['end_date']);
        }
    
        if (!empty($filters['search'])) {
            $events->where('name_event', 'LIKE', '%' . $filters['search'] . '%');
        }
        $events = $events->paginate(7);
    
        return [
                'revenue' => $revenue,
                'ticket_sold' => $ticket_sold,
                'average_revenue' => $average_revenue,
                'events' => $events,
            ];
       
    }
    
    public function getDashReport($filters)
    {
        $order = Order::with('user');

    if (!empty($filters['report_type'])) {
        if ($filters['report_type'] === 'ticket_sales') {
            $order->whereHas('detailOrder', function ($query) {
                $query->where('total', '>', 0);
            });
        } elseif ($filters['report_type'] === 'user_activity') {
            $order->whereNotNull('id_user');
        }
    }
    if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
        $order->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
    } elseif (!empty($filters['start_date'])) {
        $order->where('created_at', '>=', $filters['start_date']);
    } elseif (!empty($filters['end_date'])) {
        $order->where('created_at', '<=', $filters['end_date']);
    }
    if (!empty($filters['event'])) {
        $order->whereHas('detailOrder.ticket.event', function ($query) use ($filters) {
            $query->where('name_event', 'LIKE', '%' . $filters['event'] . '%');
        });
    }
    $order = $order->orderBy('created_at', 'ASC')->get();
    $total_transaction = DetailOrder::sum('total');
    $order_count = $order->count();
    $most_event = Event::orderBy('sold_ticket', 'DESC')->first();
        return [
            'total_transaction' => $total_transaction,
            'order_count' => $order_count,
            'order' => $order,
            'most_event' => $most_event,
        ];
    }
    public function Detail_ticket($id_ticket)
    {
        return Ticket::with(['event', 'cate'])
            ->findOrFail($id_ticket);
    }

    public function Detail_event($id_event)
    {
        return Event::with('ticket')->findOrFail($id_event);
    }

    public function Detail_user($id_user)
    {
        $user = User::findOrFail($id_user);
        $orders = Order::with('detailOrders')->where('id_user', $user->id)->get();
        $orderIds = $orders->pluck('id_order');
        $details = DetailOrder::with('ticket')->whereIn('id_order', $orderIds)->get();

        return [
            'user' => $user,
            'orders' => $orders,
            'details' => $details
        ];
    }
    public function Detail_revenue($id_event)
    {
        $detail_event = DetailOrder::with('ticket', 'order.user', 'event')
            ->where('id_event', $id_event) 
            ->get();
    
        $stats = $detail_event->reduce(function ($carry, $item) {
            $carry['revenue'] += $item->total;
            $carry['ticket_sold'] += $item->quantity;
            return $carry;
        }, ['revenue' => 0, 'ticket_sold' => 0]);
    
        $event = Event::find($id_event);
        $avg = $stats['ticket_sold'] ? $stats['revenue'] / $stats['ticket_sold'] : 0;
    
        return [
            'revenue' => $stats['revenue'],
            'ticket_sold' => $stats['ticket_sold'],
            'detail_event' => $detail_event,
            'event' => $event,
            'avg' => $avg
        ];
    }
    

    public function exportFile($type, $id, $fileType)
    {
        
        if ($type === 'revenue') {
            $data = $this->Detail_revenue($id);
            $view = 'admin.detail.revenue_pdf';
            $fileName = 'Chi_tiet_doanh_thu';
            $exportClass = new RevenueDetailExport($id);
        } elseif ($type === 'order') {
         
            $data = $this->Detail_report($id);
            $view = 'admin.detail.report_pdf';
            $fileName = 'Chi_tiet_giao_dich';
            $exportClass = new OrderDetailExport($id);
        } else {
            return redirect()->back()->with('error', 'Loại dữ liệu không hợp lệ!');
        }
    
        if ($fileType === 'pdf') {
            $pdf = Pdf::loadView($view, $data)
                ->setPaper('a4', 'portrait')
                ->setOption('defaultFont', 'DejaVu Sans');
            return $pdf->download($fileName . '.pdf');
        }
    
        if ($fileType === 'excel') {
            return Excel::download($exportClass, $fileName . '.xlsx');
        }
    
        return redirect()->back()->with('error', 'Loại file không hợp lệ!');
    }
    
    
    public function Detail_report($id_order)
    {   
        
        $report= DetailOrder::with('ticket', 'order.user')->where('id_order', $id_order)->orderBy('created_at', 'ASC')->get();
        return [
            'count'=>$report->count(),
            'report'=>$report,
        ];
    }
}
