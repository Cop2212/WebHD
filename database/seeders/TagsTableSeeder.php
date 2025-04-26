<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/TagsTableSeeder.php
public function run()
{
    $tags = [
        ['name' => 'Laravel', 'slug' => 'laravel'],
        ['name' => 'PHP', 'slug' => 'php'],
        ['name' => 'JavaScript', 'slug' => 'javascript'],
        ['name' => 'Vue.js', 'slug' => 'vuejs'],
        ['name' => 'React', 'slug' => 'react']
    ];

    foreach ($tags as $tag) {
        \App\Models\Tag::create($tag);
    }
}
}
