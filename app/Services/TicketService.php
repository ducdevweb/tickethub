<?php
namespace App\Services;

use App\Models\Cate;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Favourite;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TicketService
{
    public function getEvent($id_event){
        return Event::with('ticket')->where('id_event',$id_event)->firstOrFail();
    }
    public function getTicketDetail($id_ticket)
    {
        return Ticket::with('event')->where('id_ticket', $id_ticket)->firstOrFail();
    }

    public function getComments($ticketId)
    {
        return Cache::remember("comments_ticket_{$ticketId}", 3600, function () use ($ticketId) {
            return Comment::with('user')->where('id_ticket', $ticketId)->get();
        });
    }

    public function getTrendingTickets()
    {
        return Cache::remember('trending_tickets', 3600, function () {
            return Ticket::where('hidden_ticket', 0)
                ->orderBy('bought', 'desc')
                ->limit(10)
                ->get();
        });
    }

    public function getRelatedTickets($ticket)
    {
        if (!$ticket || !$ticket->id_cate) {
            return collect();
        }
        return Cache::remember("related_tickets_{$ticket->id_cate}", 3600, function () use ($ticket) {
            return Ticket::where('id_cate', $ticket->id_cate)
                ->where('id_ticket', '!=', $ticket->id_ticket)
                ->where('hidden_ticket', 0)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        });
    }

    public function getTicketCate()
    {
        return Cate::with('tickets')->orderByDesc('id_cate')->get();
    }

    public function getTicketsByCategory($id_cate)
    {
        return Ticket::where('id_cate', $id_cate)
            ->where('hidden_ticket', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function toggleFavourite($id_ticket)
    {
        $user_id = Auth::id();
        if (!$user_id) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập!');
        }

        $favourite = Favourite::where('id_ticket', $id_ticket)
            ->where('id_user', $user_id)
            ->first();

        if ($favourite) {
            $favourite->delete();
            return redirect()->back()->with('error', 'Đã bỏ yêu thích!');
        }

        if (!Ticket::where('id_ticket', $id_ticket)->exists()) {
            return redirect()->back()->with('error', 'Vé không tồn tại!');
        }

        Favourite::create([
            'id_ticket' => $id_ticket,
            'id_user' => $user_id,
        ]);
        return redirect()->back()->with('success', 'Đã thêm vào mục yêu thích!');
    }

    public function search($query)
    {
        return Ticket::where('name_ticket', 'LIKE', "%{$query}%")
            ->where('hidden_ticket', 0)
            ->paginate(10);
    }
}