<?php

use Illuminate\Database\Seeder;

class FrecuenciaCompraCafeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\FrecuenciaCompraCafe::firstOrCreate([
            'tipo' => 'Semanal',
        ]);
        \App\Models\FrecuenciaCompraCafe::firstOrCreate([
            'tipo' => 'Quincenal',
        ]);
        \App\Models\FrecuenciaCompraCafe::firstOrCreate([
            'tipo' => 'Mensual',
        ]);
        \App\Models\FrecuenciaCompraCafe::firstOrCreate([
            'tipo' => 'Ninguna',
        ]);
    }
}
