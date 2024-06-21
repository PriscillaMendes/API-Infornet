<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicos = [];

        for ($i = 1; $i <= 75; $i++) {
            $servicos[] = [
                'nome' => 'Serviço ' . $i,
                'situacao' => 'ativo',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('servicos')->insert($servicos);
    }
}
