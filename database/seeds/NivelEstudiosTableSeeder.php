<?php

use Illuminate\Database\Seeder;

class NivelEstudiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => 'Sin Estudios',
        ]);
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => '1 a 5 años de Primaria',
        ]);
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => 'De 6 a 9 años de Secundaria',
        ]);
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => 'De 9 a 11 años de Secundaria',
        ]);
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => 'Técnico',
        ]);
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => 'Tecnológico',
        ]);
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => 'Profesional',
        ]);
        \App\Models\NivelEstudios::firstOrCreate([
            'tipo' => 'Posgrado',
        ]);
    }
}
