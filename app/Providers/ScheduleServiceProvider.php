<?php

namespace App\Providers;

use App\Console\Commands\UpdateEventStatus;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            UpdateEventStatus::class,
        ]);
    }

    public function boot(Schedule $schedule)
    {
        $schedule->command('orders:clear-pending')->everyMinute();
        $schedule->command('event:update-status')->everyMinute();

        Log::info("✅ Lịch trình đã được khởi chạy thành công.");
    }
}
