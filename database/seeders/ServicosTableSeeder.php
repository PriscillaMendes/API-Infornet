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
        $servicos = [
            ['nome' => 'Reboque', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Chaveiro', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Troca de pneu', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Troca de bateria', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Socorro mecânico', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Guincho leve', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Guincho pesado', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Resgate em rodovia', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Desbloqueio de ignição', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Abastecimento emergencial', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Troca de óleo', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Verificação de freios', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Verificação de suspensão', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Verificação de faróis', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Diagnóstico de motor', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Reparo elétrico', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Reparo de ar condicionado', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Inspeção de segurança', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Alinhamento e balanceamento', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Polimento de faróis', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Serviço de funilaria', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Pintura automotiva', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Lavagem completa', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Higienização interna', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Serviço de vidro', 'situacao' => 'disponivel', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('servicos')->insert($servicos);
    }
}
