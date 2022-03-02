<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Italo Morales F',
            'email' => 'i@admin.com',
            'password' => bcrypt('123456')
        ]);

        \App\Models\Post::factory(24)->create();

    }
}
