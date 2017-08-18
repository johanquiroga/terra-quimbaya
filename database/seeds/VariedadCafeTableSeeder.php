<?php

use Illuminate\Database\Seeder;

class VariedadCafeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    \App\Models\VariedadCafe::firstOrCreate([
		    'tipo' => 'TYPICA',
	    ]);
	    \App\Models\VariedadCafe::firstOrCreate([
		    'tipo' => 'BORBON',
	    ]);
	    \App\Models\VariedadCafe::firstOrCreate([
		    'tipo' => 'CATURRA',
	    ]);
	    \App\Models\VariedadCafe::firstOrCreate([
		    'tipo' => 'CASTILLO',
	    ]);
	    \App\Models\VariedadCafe::firstOrCreate([
		    'tipo' => 'MARAGOGIPE',
	    ]);
	    \App\Models\VariedadCafe::firstOrCreate([
		    'tipo' => 'TABI',
	    ]);
	    \App\Models\VariedadCafe::firstOrCreate([
		    'tipo' => 'OTRA',
	    ]);
    }
}
