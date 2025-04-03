<?php

namespace App\Services\Admin;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CreateService
{
    public function createEvent(Request $request)
    {
        $event = new Event();

        $event->name_event = $request->name_event;
        $event->location = $request->location;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->max_ticket = $request->max_ticket;
        $event->sold_ticket = 0;
        $event->description_event = $request->description_event;

        if ($request->hasFile('event_img')) {
            $file = $request->file('event_img');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/events'), $fileName);
            $event->event_img = '/uploads/events/' . $fileName;
        }

        $event->save();

        return redirect()->back()->with('success', 'Thêm sự kiện thành công!');
    }
    public function create_ticket(Request $request)
{
    $request->validate([
        'id_event' => 'required|exists:events,id_event',
        'id_cate' => 'required|exists:cate,id_cate',
        'name_ticket' => 'required|string|max:100',
        'price_ticket' => 'required|numeric|min:0',
        'sale_ticket' => 'nullable|numeric|min:0|max:100',
        'quantity_ticket' => 'required|integer|min:1',
        'description_ticket' => 'nullable|string',
        'img_ticket' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'status' => 'required|in:active,inactive',
        'hidden_ticket' => 'required|boolean',
    ]);

    $ticket = new Ticket();

    $ticket->id_event = $request->id_event;
    $ticket->id_cate = $request->id_cate;
    $ticket->name_ticket = $request->name_ticket;
    $ticket->price_ticket = $request->price_ticket;
    $ticket->type_ticket=$request->type_ticket;
    $ticket->bought=0;
    $ticket->sale_ticket = $request->sale_ticket ?? 0;
    $ticket->quantity_ticket = $request->quantity_ticket;
    $ticket->description_ticket = $request->description_ticket;
    $ticket->hidden_ticket = $request->hidden_ticket;

    if ($request->hasFile('img_ticket')) {
        $file = $request->file('img_ticket');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/tickets'), $fileName);
        $ticket->img_ticket = '/uploads/tickets/' . $fileName;
    }

    $ticket->save();

    return redirect('/admin/ticket')->with('success', 'Thêm vé thành công!');
}

}