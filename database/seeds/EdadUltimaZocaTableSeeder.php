<?php

use Illuminate\Database\Seeder;

class EdadUltimaZocaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EdadUltimaZoca::firstOrCreate([
            'tipo' => 'Entre 1 y 3 años',
        ]);
        \App\Models\EdadUltimaZoca::firstOrCreate([
            'tipo' => 'Entre 3 y 5 años',
        ]);
        \App\Models\EdadUltimaZoca::firstOrCreate([
            'tipo' => 'Entre 5 y 7 años',
        ]);
        \App\Models\EdadUltimaZoca::firstOrCreate([
            'tipo' => 'Más de 7 años',
        ]);
    }
}
