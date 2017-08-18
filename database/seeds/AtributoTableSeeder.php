<?php

use Illuminate\Database\Seeder;

class AtributoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Atributo::firstOrCreate([
            'nombreAtributo' => 'tipoBeneficio',
            'descripcionAtributo' => 'Escoger una de las opciones',
	        'opciones' => 'Húmedo,Seco,Semiseco'
        ]);
	    \App\Models\Atributo::firstOrCreate([
		    'nombreAtributo' => 'fragancia',
		    'descripcionAtributo' => 'Escoger una de las opciones para fragancia/aroma',
		    'opciones' => "Muy pronunciado,Medianamente pronunciado,Poco pronunciado"
	    ]);
	    \App\Models\Atributo::firstOrCreate([
		    'nombreAtributo' => 'acidez',
		    'descripcionAtributo' => 'Escoger una de las opciones que describa el sabor del producto',
		    'opciones' => "Pronunciada,Poco pronunciada"
	    ]);
	    \App\Models\Atributo::firstOrCreate([
		    'nombreAtributo' => 'dulce',
		    'descripcionAtributo' => 'Escoger una de las opciones que describa el sabor del producto',
		    'opciones' => "Acentuado, Poco acentuado"
	    ]);
        \App\Models\Atributo::firstOrCreate([
            'nombreAtributo' => 'tipoEmpaque',
            'descripcionAtributo' => "Presentacion: 1 kilo, &half; kilo ( 1 libra) o &half; libra",
            'opciones' => "1 Kilo,&half; Kilo (1 Libra),&half; Libra"
        ]);
        \App\Models\Atributo::firstOrCreate([
            'nombreAtributo' => 'trilla',
            'descripcionAtributo' => 'Escoger molido o en grano',
            'opciones' => "Molido,Grano"
        ]);
        \App\Models\Atributo::firstOrCreate([
            'nombreAtributo' => 'tostion',
            'descripcionAtributo' => 'Escoger claro, medio u oscuro',
            'opciones' => "Claro,Medio,Oscuro"
        ]);
	    \App\Models\Atributo::firstOrCreate([
		    'nombreAtributo' => 'molienda',
		    'descripcionAtributo' => 'Escoger una de las opciones',
		    'opciones' => "Fina,Media,Gruesa"
	    ]);
	    \App\Models\Atributo::firstOrCreate([
		    'nombreAtributo' => 'sabor',
		    'descripcionAtributo' => 'Indicar el sabor del café',
	    ]);
	    \App\Models\Atributo::firstOrCreate([
		    'nombreAtributo' => 'saborResidual',
		    'descripcionAtributo' => '',
	    ]);
    }
}
