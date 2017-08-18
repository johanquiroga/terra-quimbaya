<?php

use Illuminate\Database\Seeder;

class DensidadSiembraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\DensidadSiembra::firstOrCreate([
            'tipo' => 'Menos de 500 arboles /ha',
        ]);
        \App\Models\DensidadSiembra::firstOrCreate([
            'tipo' => 'Entre 500 y 1500 arboles /ha',
        ]);
        \App\Models\DensidadSiembra::firstOrCreate([
            'tipo' => 'Entre 1500 y 2500 arboles /ha',
        ]);
        \App\Models\DensidadSiembra::firstOrCreate([
            'tipo' => 'Entre 2500 y 4500 arboles /ha',
        ]);
        \App\Models\DensidadSiembra::firstOrCreate([
            'tipo' => 'Entre 4.500 y 6.500 arboles /ha',
        ]);
        \App\Models\DensidadSiembra::firstOrCreate([
            'tipo' => 'Mas de 6.500 arboles /ha',
        ]);
    }
}
