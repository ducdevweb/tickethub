<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    protected function successRedirect(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('success', $message);
    }

    protected function errorRedirect(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('error', $message);
    }
}
