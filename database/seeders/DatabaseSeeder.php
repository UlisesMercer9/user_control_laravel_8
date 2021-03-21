<?php

namespace Database\Seeders;

use App\Models\Apellido;
use App\Models\User;
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
        

        \App\Models\Apellido::factory(100)->create();
    }
}
