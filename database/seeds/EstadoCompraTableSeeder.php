<?php

use Illuminate\Database\Seeder;

class EstadoCompraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EstadoCompra::firstOrCreate([
        	'estado' => 'aceptada',
        ]);
	    \App\Models\EstadoCompra::firstOrCreate([
		    'estado' => 'pendiente',
	    ]);
	    \App\Models\EstadoCompra::firstOrCreate([
		    'estado' => 'rechazada',
	    ]);
	    \App\Models\EstadoCompra::firstOrCreate([
		    'estado' => 'devuelto',
	    ]);
    }
}
