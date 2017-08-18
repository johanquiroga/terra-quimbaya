<?php

use Illuminate\Database\Seeder;

class EcotopoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'Del 101 A al	106 A',
        ]);
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'Del 101 B  al  113 B',
        ]);
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'Del 201 A  al  221 A',
        ]);
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'Del 201 B  al  214 B',
        ]);
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'Del 301 A  al  319 A',
        ]);
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'Del 301 B  al  310 B',
        ]);
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'Del 401  al  403',
        ]);
        \App\Models\Ecotopo::firstOrCreate([
            'tipo' => 'No sabe',
        ]);
    }
}
