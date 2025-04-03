<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\Admin\CreateService;

class AdminCreate extends Controller
{
    protected $createService;

    public function __construct(CreateService $createService)
    {
        $this->createService = $createService;
    }
    public function create_event()
    {
        return view("admin.create.create_event");
    }
    public function add_event(Request $request)
    {
        $request->validate([
            'name_event' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date_start' => 'required|date|after:now',
            'date_end' => 'required|date|after:date_start',
            'max_ticket' => 'required|numeric|min:1',
            'event_img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description_event' => 'nullable|string',
        ]);

        return $this->createService->createEvent($request);
    }
    public function create_ticket()
    {
        $event=Event::all();
        $cate=Cate::all();
        return view("admin.create.create_ticket",compact('event','cate'));
    }
    public function add_ticket(Request $request){
        return $this->createService->create_ticket($request);
    }
    public function create_user()
    {
        return view("admin.create.create_user");
    }
}
