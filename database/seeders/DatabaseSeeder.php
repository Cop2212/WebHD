<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tạo admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'reputation' => 1000,
            'email_verified_at' => now()
        ]);

        // Tạo 10 user thường
        $users = User::factory(10)->create();

        // Tạo các tags
        $this->call(TagsTableSeeder::class);
        $tags = Tag::all();

        // Tạo 50 câu hỏi và gắn tags ngẫu nhiên
        Question::factory(50)
        ->create(['user_id' => fn() => $users->random()->id])
        ->each(function ($question) use ($tags) {
            $question->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')
            );
        });

    }
}
