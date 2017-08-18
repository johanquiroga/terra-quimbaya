<?php

use Illuminate\Database\Seeder;

class TipoSolicitudTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\TipoSolicitud::firstOrCreate([
        	'tipo' => 'devolucion',
        ]);
        \App\Models\TipoSolicitud::firstOrCreate([
        	'tipo' => 'compra',
        ]);
        \App\Models\TipoSolicitud::firstOrCreate([
        	'tipo' => 'pregunta',
        ]);
    }
}
