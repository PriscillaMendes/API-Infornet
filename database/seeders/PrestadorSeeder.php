<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class PrestadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        
        $cidades = [
            'Belo Horizonte',
            'Contagem',
            'Betim',
            'Uberlândia',
            'Juiz de Fora',
            'Montes Claros',
            'Ribeirão das Neves',
            'Uberaba',
            'Governador Valadares',
            'Ipatinga',
        ];

        for ($i = 0; $i < 25; $i++) {
            $cidade = $faker->randomElement($cidades);
            DB::table('prestador')->insert([
                'nome' => $faker->company,
                'logradouro' => $faker->streetName,
                'bairro' => $faker->streetSuffix,
                'numero' => $faker->buildingNumber,
                'latitude' => $faker->latitude(-20, -18),
                'longitude' => $faker->longitude(-44, -42),
                'cidade' => $cidade,
                'UF' => 'MG',
                'situacao' => 'disponível',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
