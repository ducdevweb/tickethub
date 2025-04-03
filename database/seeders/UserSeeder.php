<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 5 user mẫu
        $users = [
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('123456'),
                'img' => 'avatar1.jpg',
                'status' => 1, 
            ],
            [
                'name' => 'Trần Thị B',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('123456'),
                'img' => 'avatar2.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Lê Văn C',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('123456'),
                'img' => 'avatar3.jpg',
                'status' => 0,
            ],
            [
                'name' => 'Phạm Thị D',
                'email' => 'user4@gmail.com',
                'password' => Hash::make('123456'),
                'img' => 'avatar4.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'img' => 'admin.jpg',
                'status' => 1,
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}