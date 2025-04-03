<?php

namespace App\Services\admin;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;

Class DestroyService{
    public function delete_event($id_event)
{
    $event = Event::findOrFail($id_event);
    $event->delete(); 
    return redirect()->route('admin.index.event')->with('success', 'Đã xóa sự kiện vào thùng rác!');
}
public function delete_ticket($id_ticket)
{
    $ticket = Ticket::findOrFail($id_ticket);
    $ticket->delete(); 
    return redirect()->route('admin.index.ticket')->with('success', 'Đã xóa vé vào thùng rác!');
}
public function delete_user($id)
{
    $user = User::findOrFail($id);
    $user->delete(); 
    return redirect()->route('admin.index.user')->with('success', 'Đã xóa người dùng vào thùng rác!');
}
}