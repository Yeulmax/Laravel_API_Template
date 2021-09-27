<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //TODO A décommenter
        //$this->call(PostTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
