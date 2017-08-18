<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDireccionResidencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direccionResidencia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direccion', 60);
            $table->string('direccionAuxiliar', 60);
            $table->string('codigoPostal', 10);
            $table->string('ciudad', 45);
            $table->string('departamento', 45);
            $table->string('pais', 45);
            $table->string('idComprador', 10);

            $table->foreign('idComprador')->references('id')->on('comprador')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('direccionResidencia');
    }
}
