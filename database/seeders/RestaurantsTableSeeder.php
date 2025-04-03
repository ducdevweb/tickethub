<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantsTableSeeder extends Seeder
{
    public function run()
    {
        Restaurant::create([
            'name' => 'Nhà Hàng Lẩu Rau Đà Lạt',
            'address' => 'Số 15 Nguyễn Văn Cừ, Phường 1, Đà Lạt',
            'phone' => '0263 123 4567',
            'description' => 'Nhà hàng chuyên phục vụ lẩu rau sạch và các món đặc sản Đà Lạt.',
        ]);

        Restaurant::create([
            'name' => 'Quán Ăn Hương Rừng',
            'address' => 'Số 27 Trần Phú, Phường 3, Đà Lạt',
            'phone' => '0263 234 5678',
            'description' => 'Không gian ấm cúng, phục vụ các món ăn dân dã như gà nướng, cơm lam.',
        ]);

        Restaurant::create([
            'name' => 'Bánh Tráng Nướng 36',
            'address' => 'Số 36 Tăng Bạt Hổ, Phường 1, Đà Lạt',
            'phone' => '0263 345 6789',
            'description' => 'Quán bánh tráng nướng nổi tiếng, phù hợp cho bữa ăn nhẹ.',
        ]);

        Restaurant::create([
            'name' => 'Nhà Hàng Gỗ Đà Lạt',
            'address' => 'Số 8 Lê Đại Hành, Phường 1, Đà Lạt',
            'phone' => '0263 456 7890',
            'description' => 'Nhà hàng sang trọng với thực đơn đa dạng, thích hợp cho gia đình.',
        ]);
    }
}