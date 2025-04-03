<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo 3 danh mục (cate)
        $categories = [
            ['name_cate' => 'Âm nhạc', 'hidden_cate' => 0],
            ['name_cate' => 'Hội thảo', 'hidden_cate' => 0],
            ['name_cate' => 'Tham quan', 'hidden_cate' => 0],
        ];
        DB::table('cate')->insert($categories);

        // 2. Tạo 3 người dùng (users)
        $users = [
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'user1@example.com',
                'phone' => '0912345678',
                'password' => Hash::make('password123'),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Thị B',
                'email' => 'user2@example.com',
                'phone' => '0923456789',
                'password' => Hash::make('password123'),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lê Văn C',
                'email' => 'user3@example.com',
                'phone' => '0934567890',
                'password' => Hash::make('password123'),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('users')->insert($users);

        // 3. Tạo 15 sự kiện (events)
        $events = [];
        for ($i = 1; $i <= 15; $i++) {
            $events[] = [
                'name_event' => 'Sự kiện ' . $i,
                'location' => 'Địa điểm ' . $i,
                'date_start' => now()->addDays($i),
                'date_end' => now()->addDays($i + 1),
                'description_event' => 'Mô tả cho sự kiện ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('events')->insert($events);

        // 4. Tạo 15 vé (ticket)
        $tickets = [];
        for ($i = 1; $i <= 15; $i++) {
            $cateId = ($i % 3) + 1; // Chia đều cho 3 danh mục
            $tickets[] = [
                'id_event' => $i,
                'id_cate' => $cateId,
                'name_ticket' => 'Vé sự kiện ' . $i,
                'seri_ticket' => 'SERI' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'price_ticket' => 100000 * $i,
                'sale_ticket' => $i % 2 == 0 ? 50000 * $i : 0, // Một số vé có giảm giá
                'quantity_ticket' => 50,
                'description_ticket' => 'Mô tả vé cho sự kiện ' . $i,
                'img_ticket' => '/images/ticket' . $i . '.jpg',
                'status' => 'available',
                'hidden_ticket' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('ticket')->insert($tickets);

        // 5. Tạo 10 bình luận (comment)
        $comments = [
            // User 1
            [
                'id_user' => 1,
                'id_ticket' => 1,
                'star' => 5,
                'text' => 'Rất tuyệt vời, đáng tiền!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 1,
                'id_ticket' => 2,
                'star' => 4,
                'text' => 'Sự kiện hay nhưng chỗ ngồi hơi xa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 1,
                'id_ticket' => 3,
                'star' => 5,
                'text' => 'Không thể bỏ lỡ!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 1,
                'id_ticket' => 4,
                'star' => 3,
                'text' => 'Tạm được, cần cải thiện âm thanh.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // User 2
            [
                'id_user' => 2,
                'id_ticket' => 5,
                'star' => 4,
                'text' => 'Dịch vụ tốt, giá hơi cao.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'id_ticket' => 6,
                'star' => 5,
                'text' => 'Tuyệt vời, sẽ quay lại!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'id_ticket' => 7,
                'star' => 2,
                'text' => 'Không đáng giá, tổ chức kém.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // User 3
            [
                'id_user' => 3,
                'id_ticket' => 8,
                'star' => 5,
                'text' => 'Trải nghiệm tuyệt vời!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 3,
                'id_ticket' => 9,
                'star' => 4,
                'text' => 'Rất tốt nhưng cần thêm chỗ ngồi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 3,
                'id_ticket' => 10,
                'star' => 3,
                'text' => 'Bình thường, không có gì đặc biệt.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('comment')->insert($comments);
    }
}