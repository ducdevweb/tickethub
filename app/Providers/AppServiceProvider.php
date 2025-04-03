<?php

namespace App\Providers;

use App\Models\Ticket;
use App\View\Composers\AuthComposer;
use App\View\Composers\CartComposer;
use App\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', CartComposer::class);
        View::composer('*', AuthComposer::class);
        View::composer('*', SidebarComposer::class);
    }
}
