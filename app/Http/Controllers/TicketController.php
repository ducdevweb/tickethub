<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\Ticket;
use App\Services\CateService;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use function Laravel\Prompts\alert;

class TicketController extends Controller
{
    /**
     * 
     *
     * @param string $type
     * @return \Illuminate\View\View
     */

    protected $cateService;
    protected $ticketService;

    public function __construct(CateService $cateService, TicketService $ticketService)
    {
        $this->cateService = $cateService;
        $this->ticketService = $ticketService;
    }
    public function showTickets(string $type)
    {
        $categories = $this->cateService->getCategories();

        $typeMap = [
            'music' => 'Âm nhạc',
            'tour' => 'Tham quan',
            'workshop' => 'Hội thảo'
        ];

        $categoryName = $typeMap[$type] ?? null;
        $category = $categories->firstWhere('name_cate', $categoryName);

        if (!$category) {
            Session::flash('error', 'Loại vé không tồn tại.');
            return redirect()->back();
        }

        $tickets = $this->ticketService->getTicketsByCategory($category->id_cate);

        $viewMap = [
            'music' => ['view' => 'user.ticket.music', 'variable' => 'music_ticket'],
            'tour' => ['view' => 'user.ticket.tour', 'variable' => 'tour_ticket'],
            'workshop' => ['view' => 'user.ticket.workshop', 'variable' => 'workshop_ticket']
        ];

        if (!array_key_exists($type, $viewMap)) {
            Session::flash('error', 'Trang này không tồn tại');
            return redirect()->back();
        }

        return view($viewMap[$type]['view'], [
            $viewMap[$type]['variable'] => $tickets,
            'cate' => $category,
            'categories' => $categories,
            'type' => $type
        ]);
    }
    public function searchTicket(Request $request){
        $query = $request->input('search');

        if (!$query) {
           return $this->errorRedirect('search', 'Vui lòng nhập từ khóa tìm kiếm!');
        }

        $tickets = $this->ticketService->search($query);

        return view('user.ticket.search', compact('tickets', 'query'));
    }
   public function showDetail($id_ticket)
{
    $ticket = $this->ticketService->getTicketDetail($id_ticket);

    if (!$ticket) {
        abort(404);
    }

    $categories = $this->cateService->getCategories();
    $ticket_relate = $this->ticketService->getRelatedTickets($ticket);
    $ticket_trend = $this->ticketService->getTrendingTickets();
    $comments = $this->ticketService->getComments($id_ticket);

    return view('user.ticket.detail', compact('ticket', 'ticket_relate', 'ticket_trend', 'comments', 'categories'));
}

    public function favourite($id_ticker)
    {
        $this->ticketService->toggleFavourite($id_ticker);
        return redirect()->back();
    }
    public function viewQr($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('ticket.viewQR', compact('ticket'));
    }
    public function detail_event($id_event){
        $event=$this->ticketService->getEvent($id_event);
        return view('user.ticket.detail_event',compact('event'));
    }
}
