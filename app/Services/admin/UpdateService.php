<?php

namespace App\Services\admin;

use App\Models\Cate;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class UpdateService
{
    public function getDashEvent($id_event)
    {
        return  Event::where("id_event", $id_event)->first();
    }
    public function update_event($id_event, Request $request)
    {
        $request->validate([
            'name_event' => 'string|max:255',
            'location' => 'string|max:255',
            'max_ticket' => 'integer|min:1',
            'date_start' => 'date',
            'date_end' => 'date|after_or_equal:date_start',
            'event_img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $event = Event::findOrFail($id_event);
        $event->name_event = $request->name_event;
        $event->location = $request->location;
        $event->max_ticket = $request->max_ticket;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->description_event = $request->description_event;

        if ($request->hasFile('img_event')) {
            $file = $request->file('img_event');
            if ($event->event_img && file_exists(public_path($event->event_img))) {
                unlink(public_path($event->event_img));
            }
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/events'), $fileName);
            $event->event_img = '/uploads/events/' . $fileName;
        }

        $event->save();

        return redirect()->back()->with('success', 'Cập nhật sự kiện thành công!');
    }
    public function getDashTicket($id_ticket)
    {
        $ticket = Ticket::where('id_ticket', $id_ticket)->orderBy('created_at', 'ASC')->first();
        $cate = Cate::all();
        $event = Event::all();
        return [
            'ticket' => $ticket,
            'event' => $event,
            'cate' => $cate
        ];
    }
    public function updateTicket($id_ticket, Request $request)
    {
        $ticket = Ticket::findOrFail($id_ticket);

        $ticket->id_event = $request->id_event;
        $ticket->id_cate = $request->id_cate;
        $ticket->name_ticket = $request->name_ticket;
        $ticket->price_ticket = $request->price_ticket;
        $ticket->sale_ticket = $request->sale_ticket ?? 0;
        $ticket->quantity_ticket = $request->quantity_ticket;
        $ticket->description_ticket = $request->description_ticket;
        $ticket->hidden_ticket = $request->hidden_ticket;

        if ($request->hasFile('img_ticket')) {
            $file = $request->file('img_ticket');
            if ($ticket->img_ticket && file_exists(public_path($ticket->img_ticket))) {
                unlink(public_path($ticket->img_ticket));
            }
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tickets'), $fileName);
            $ticket->img_ticket = '/uploads/tickets/' . $fileName;
        }

        $ticket->save();

        return redirect()->route('admin.detail.ticket', $id_ticket)->with('success', 'Cập nhật vé thành công!');
    }
}