<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PrestadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 25; $i++) {
            DB::table('prestador')->insert([
                'nome' => 'Prestador ' . $i,
                'logradouro' => 'Logradouro ' . $i,
                'bairro' => 'Bairro ' . $i,
                'numero' => (string)rand(1, 100),
                'latitude' => mt_rand(-9000000, 9000000) / 1000000,
                'longitude' => mt_rand(-18000000, 18000000) / 1000000,
                'cidade' => 'Cidade ' . $i,
                'UF' => Str::random(2),
                'situacao' => 'ativo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
