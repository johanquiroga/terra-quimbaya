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
        \App\Models\Atributo::updateOrCreate(
        	['nombreAtributo' => 'tipoBeneficio'],
            ['descripcionAtributo' => 'Escoger una de las opciones',
	        'opciones' => 'Húmedo,Seco,Semiseco,No sabe/Ninguna']
        );
	    \App\Models\Atributo::updateOrCreate(
	    	['nombreAtributo' => 'fragancia'],
		    ['descripcionAtributo' => 'Escoger una de las opciones para fragancia/aroma',
		    'opciones' => "Muy pronunciado,Medianamente pronunciado,Poco pronunciado,No sabe/Ninguna"]
	    );
	    \App\Models\Atributo::updateOrCreate(
	    	['nombreAtributo' => 'acidez'],
		    ['descripcionAtributo' => 'Escoger una de las opciones que describa el sabor del producto',
		    'opciones' => "Pronunciada,Poco pronunciada,No sabe/Ninguna"]
	    );
	    \App\Models\Atributo::updateOrCreate(
	    	['nombreAtributo' => 'dulce'],
		    ['descripcionAtributo' => 'Escoger una de las opciones que describa el sabor del producto',
		    'opciones' => "Acentuado, Poco acentuado,No sabe/Ninguna"]
	    );
        \App\Models\Atributo::updateOrCreate(
        	['nombreAtributo' => 'tipoEmpaque'],
            ['descripcionAtributo' => "Presentacion: 1 kilo, &half; kilo ( 1 libra) o &half; libra",
            'opciones' => "1 Kilo,&half; Kilo (1 Libra),&half; Libra,No sabe/Ninguna"]
        );
        \App\Models\Atributo::updateOrCreate(
        	['nombreAtributo' => 'trilla'],
            ['descripcionAtributo' => 'Escoger molido o en grano',
            'opciones' => "Molido,Grano,No sabe/Ninguna"]
        );
        \App\Models\Atributo::updateOrCreate(
        	['nombreAtributo' => 'tostion'],
            ['descripcionAtributo' => 'Escoger claro, medio u oscuro',
            'opciones' => "Claro,Medio,Oscuro,No sabe/Ninguna"]
        );
	    \App\Models\Atributo::updateOrCreate(
	    	['nombreAtributo' => 'molienda'],
		    ['descripcionAtributo' => 'Escoger una de las opciones',
		    'opciones' => "Fina,Media,Gruesa,No sabe/Ninguna"]
	    );
	    \App\Models\Atributo::updateOrCreate(
	    	['nombreAtributo' => 'sabor'],
		    ['descripcionAtributo' => 'Indicar el sabor del café']
	    );
	    \App\Models\Atributo::updateOrCreate(
	    	['nombreAtributo' => 'saborResidual'],
		    ['descripcionAtributo' => '']
	    );
    }
}
