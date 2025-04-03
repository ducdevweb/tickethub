<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthComposer
{
    public function compose(View $view) 
    {
        $user = Auth::check() ? Auth::user() : null; 
        $view->with('user', $user); 
    }
}