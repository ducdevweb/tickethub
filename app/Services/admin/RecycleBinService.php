<?php
namespace App\Services\Admin;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;

class RecycleBinService
{
    public function getTrashedItems()
    {
        return [
            'events' => Event::onlyTrashed()->get(),
            'tickets' => Ticket::onlyTrashed()->get(),
            'users' => User::onlyTrashed()->get()
        ];
    }

    public function restoreEvent($id_event)
    {
        $event = Event::onlyTrashed()->findOrFail($id_event);
        $event->restore();
    }

    public function forceDeleteEvent($id_event)
    {
        $event = Event::onlyTrashed()->findOrFail($id_event);
        if ($event->img_event && file_exists(public_path($event->img_event))) {
            unlink(public_path($event->img_event)); 
        }
        $event->forceDelete();
    }

    public function restoreTicket($id_ticket)
    {
        $ticket = Ticket::onlyTrashed()->findOrFail($id_ticket);
        $ticket->restore();
    }

    public function forceDeleteTicket($id_ticket)
    {
        $ticket = Ticket::onlyTrashed()->findOrFail($id_ticket);
        if ($ticket->img_ticket && file_exists(public_path($ticket->img_ticket))) {
            unlink(public_path($ticket->img_ticket)); 
        }
        $ticket->forceDelete();
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
    }

    public function forceDeleteUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar)); 
        }
        $user->forceDelete();
    }
}