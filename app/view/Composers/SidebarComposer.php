<?php

namespace App\View\Composers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view) 
    {
      $sideBar=Ticket::orderByDesc("created_at")->limit(3)->get();
      $view->with("siderBar",$sideBar);
    }
}