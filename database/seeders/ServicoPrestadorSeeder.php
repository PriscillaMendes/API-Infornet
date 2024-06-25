<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServicoPrestadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestadorIds = DB::table('prestador')->pluck('id');
        $servicoIds = DB::table('servicos')->pluck('id')->toArray();
        shuffle($servicoIds); 
       
        $index = 0;

        foreach ($prestadorIds as $prestadorId) {
            $assignedServices = array_rand(array_flip($servicoIds), 3);

            foreach ($assignedServices as $servicoId) {
                DB::table('servico_prestador')->insert([
                    'prestador_id' => $prestadorId,
                    'servico_id' => $servicoId,
                    'km_saida' => rand(10, 50),
                    'valor_saida' => rand(100, 500),
                    'valor_km_excedente' => rand(5, 20),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
