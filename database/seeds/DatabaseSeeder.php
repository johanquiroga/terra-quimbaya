<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsuarioTableSeeder::class);
        $this->call(AtributoTableSeeder::class);
        $this->call(VariedadCafeTableSeeder::class);

        $this->call(DensidadSiembraTableSeeder::class);
        $this->call(EcotopoTableSeeder::class);
        $this->call(EdadUltimaZocaTableSeeder::class);
        $this->call(NivelEstudiosTableSeeder::class);
        $this->call(TipoBeneficioTableSeeder::class);
        $this->call(FrecuenciaCompraCafeTableSeeder::class);
        $this->call(TipoSolicitudTableSeeder::class);
        $this->call(MetodoPagoTableSeeder::class);
	    $this->call(EstadoCompraTableSeeder::class);

    }
}
