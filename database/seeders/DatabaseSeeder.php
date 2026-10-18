<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'pustakawan@del.ac.id'],
            [
                'name' => 'Pustakawan Del',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->call([
            KategoriSeeder::class,
            BukuSeeder::class,
        ]);
    }
}