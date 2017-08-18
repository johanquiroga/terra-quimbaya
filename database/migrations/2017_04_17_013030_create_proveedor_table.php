<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            //$table->increments('id');
            $table->string('id', 10)->primary();
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('nombreFinca', 45);
            $table->integer('edadProveedor')->unsigned();
            $table->string('telefono', 45);
            $table->integer('alturaFinca')->unsigned();
            $table->decimal('extensionFinca', 6, 2)->unsigned();
            $table->decimal('extensionLotes', 6, 2)->unsigned();
            $table->integer('idDensidadSiembra')->unsigned();
            $table->integer('añosCafetal')->unsigned();
            $table->integer('idEdadUltimaZoca')->unsigned();
            $table->integer('idTipoBeneficio')->unsigned();
            $table->integer('idEcotopo')->unsigned();
            $table->integer('nucleoFamiliar')->unsigned();
            $table->integer('idNivelEstudios')->unsigned();
            $table->integer('personasDependientesFinca')->unsigned();
            $table->boolean('estado')->default(true);
	        $table->string('idAdministrador', 10)->nullable();
            $table->timestamps();

            $table->foreign('idDensidadSiembra')->references('id')->on('densidadSiembra')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idEdadUltimaZoca')->references('id')->on('edadUltimaZoca')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idTipoBeneficio')->references('id')->on('tipoBeneficio')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idEcotopo')->references('id')->on('ecotopo')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idNivelEstudios')->references('id')->on('nivelEstudios')->onDelete('restrict')->onUpdate('cascade');
	        $table->foreign('idAdministrador')->references('id')->on('administrador')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proveedor');
    }
}
