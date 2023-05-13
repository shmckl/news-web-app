<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    //: void
    public function run()
    {

        $this->call([
            AdminUserSeeder::class,
            UserTableSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
