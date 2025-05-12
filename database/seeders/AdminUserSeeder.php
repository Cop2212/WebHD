<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo tài khoản admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'luuquocgia2212@gmail.com', // Thay đổi email nếu cần
            'password' => Hash::make('22122002'), // Mật khẩu của admin
            'is_admin' => 1, // Cột này sẽ xác định đây là tài khoản admin
        ]);
    }
}
