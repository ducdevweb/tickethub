<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class UpdateEventStatus extends Command
{
    protected $signature = 'event:update-status';
    protected $description = 'Cập nhật trạng thái sự kiện dựa vào thời gian hiện tại';

    public function handle()
    {
        $now = Carbon::now();

        Event::where('date_start', '>', $now)
            ->update(['status' => 'Chưa bắt đầu']);

        Event::where('date_start', '<=', $now)
            ->where('date_end', '>=', $now)
            ->update(['status' => 'Đang diễn ra']);

        Event::where('date_end', '<', $now)
            ->update(['status' => 'Đã kết thúc']);

        $this->info('✅ Trạng thái sự kiện đã được cập nhật!');
    }
}
