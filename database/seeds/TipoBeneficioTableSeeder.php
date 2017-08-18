<?php

use Illuminate\Database\Seeder;

class TipoBeneficioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\TipoBeneficio::firstOrCreate([
            'tipo' => 'Húmedo',
        ]);
        \App\Models\TipoBeneficio::firstOrCreate([
            'tipo' => 'Seco',
        ]);
        \App\Models\TipoBeneficio::firstOrCreate([
            'tipo' => 'Semiseco',
        ]);
    }
}
