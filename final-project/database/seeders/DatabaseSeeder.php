<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('disciplines')->insert([
            [
                'name' => 'Football',
            ],
            [
                'name' => 'Chess',
            ],
            [
                'name' => 'Basketball',
            ],
            [
                'name' => 'Tennis',
            ]
        ]);
    }
}
