<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $faker = fake('ko_KR');

        for($i = 0; $i < 3; $i++){
            Kategori::create([
                'name' => $faker->name()
            ]);
        }

        User::create([
            'name' => 'Admin-'.$faker->name(),
            'email' => 'adm@c.m',
            'password' => Hash::make(12345),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Editor-'.$faker->name(),
            'email' => 'edt@c.m',
            'password' => Hash::make(12345),
            'role' => 'editor'
        ]);
    }
}
