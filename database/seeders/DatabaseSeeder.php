<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conta;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Conta::factory(10)->create();
    }
}
