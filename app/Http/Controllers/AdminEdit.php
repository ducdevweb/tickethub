<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Services\admin\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminEdit extends Controller
{
    protected $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;
    }
    public function edit_ticket($id_ticket)
    {
        $data = $this->updateService->getDashTicket($id_ticket);
        return view("admin.edit.ticket_edit", compact('data'));
    }
    public function update_ticket($id_ticket, Request $request)
    {
        
        $request->validate([
            'name_ticket' => 'required|string|min:6',
            'price_ticket' => 'required|numeric|min:1',
            'sale_ticket' => 'nullable|numeric|min:0',
            'quantity_ticket' => 'required|numeric|min:1',
            'img_ticket' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'id_event' => 'required|exists:events,id_event',
            'id_cate' => 'required|exists:cate,id_cate',
            'hidden_ticket' => 'required|in:0,1',
            'description_ticket' => 'nullable|string'
        ]);

        return $this->updateService->updateTicket($id_ticket, $request);
    }
    public function edit_event($id_event)
    {
        $event = $this->updateService->getDashEvent($id_event);
        return view("admin.edit.event_edit", compact("event"));
    }
    public function update_event(Request $request, $id_event)
    {
        return $this->updateService->update_event($id_event, $request);
    }

    public function edit_user()
    {
        return view("admin.edit.user_edit");
    }
    public function update_user($id) {
        $user = User::findOrFail($id);
        $user->status = !$user->status; 
        $user->save();
        return redirect()->back()->with('success', 'Cập nhật người dùng thành công');
    }
    
}
