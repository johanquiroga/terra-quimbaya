<?php

use Illuminate\Database\Seeder;

class MetodoPagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\MetodoPago::firstOrCreate([
        	'metodo' => 'Contraentrega'
        ]);
	    \App\Models\MetodoPago::firstOrCreate([
		    'metodo' => 'Externo'
	    ]);
    }
}
