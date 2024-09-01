<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rodovia;

class RodoviaSeeder extends Seeder
{
    public function run()
    {
        // Caminho para o arquivo CSV na raiz do projeto
        $csvFile = fopen(base_path('rodovias.csv'), 'r');

        // Ignora o cabeçalho
        fgetcsv($csvFile);

        // Lê os dados do arquivo CSV
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            Rodovia::create([
                'id' => $data[0],
                'uf_id' => $data[1],
                'rodovia' => $data[2],
            ]);
        }

        fclose($csvFile);
    }
}
