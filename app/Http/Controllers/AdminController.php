<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Services\admin\DashBoardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $dashBoardService;

    public function __construct(DashBoardService $dashBoardService)
    {
        $this->dashBoardService = $dashBoardService;
    }
    public function index()
    {
        $getData = $this->dashBoardService->getDashBoard();
        return view("admin.index.index", compact('getData'));
    }
    
    public function user(Request $request)
    {
        $filters = $request->all();
        $getData = $this->dashBoardService->getDashUser($filters);
        return view("admin.index.manager_user", compact('getData'));
    }

    public function ticket(Request $request)
    {
        $filters = $request->all();
        $event = Event::all();
        $cate = Cate::all();
        $tickets = $this->dashBoardService->getTickets($filters);
        return view("admin.index.manager_ticket", compact('tickets', 'event', 'cate'));
    }
    public function revenue(Request $request)
    {
        $filters= $request->all();
        $data = $this->dashBoardService->getDashRevenue($filters);
        return view("admin.index.revenue", compact('data'));
    }
    public function report(Request $request)
    {
        $filters= $request->all();
        $data = $this->dashBoardService->getDashReport($filters);
        return view("admin.index.report", compact("data"));
    }
    public function event(Request $request)
    {
        $filters= $request->all();
        $data = $this->dashBoardService->getDashEvent($filters);
        return view("admin.index.event", compact('data'));
    }
    public function showMap($id)
{
    $event = Event::findOrFail($id);
    return view('admin.detail.map', compact('event'));
}

    public function setting()
    {
        return view("admin.index.setting");
    }
    public function booking()
    {
        return view("admin.index.booking_manager");
    }
    //detail
    public function ticket_detail($id_ticket)
    {
        $ticket = $this->dashBoardService->Detail_ticket($id_ticket);
        return view("admin.detail.detail_ticket", compact('ticket'));
    }

    public function event_detail($id_event)
    {
        $data = $this->dashBoardService->Detail_event($id_event);
        return view("admin.detail.event_detail", compact('data'));
    }
    public function user_detail($id_user)
    {
        $data = $this->dashBoardService->Detail_user($id_user);
        return view("admin.detail.user_detail", compact("data"));
    }
    public function detail_revenue($id_event)
    {
        $data = $this->dashBoardService->Detail_revenue($id_event);
        return view("admin.detail.revenue_detail", compact("data"));
    }
  
        public function exportFile($type, $id, $fileType)
        {
            return $this->dashBoardService->exportFile($type, $id, $fileType);
        }
    public function detail_report($id_order)
    {
        $data = $this->dashBoardService->detail_report($id_order);
        return view("admin.detail.report_detail",compact("data"));
    }

    
}
