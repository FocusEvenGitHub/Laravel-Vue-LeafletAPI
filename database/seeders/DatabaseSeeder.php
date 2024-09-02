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
        // Primeiro execute o UfSeeder para garantir que as referências de estado sejam válidas
        $this->call(UfSeeder::class);

        // Depois, execute o RodoviaSeeder que depende dos dados do UfSeeder
        $this->call(RodoviaSeeder::class);
    }
}
