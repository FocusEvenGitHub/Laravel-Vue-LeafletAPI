<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Uf;

class UfSeeder extends Seeder
{
    public function run()
    {
        // Caminho para o arquivo CSV na raiz do projeto
        $csvFile = fopen(base_path('uf.csv'), 'r');

        // Ignora o cabeçalho
        fgetcsv($csvFile);

        // Lê os dados do arquivo CSV
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            Uf::create([
                'id' => $data[0],
                'uf' => $data[1],
            ]);
        }

        fclose($csvFile);
    }
}

