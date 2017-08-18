<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbicacionFincaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicacionFinca', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vereda', 60);
            $table->string('corregimiento', 60);
            $table->string('ciudad', 45);
            $table->string('departamento', 45);
            $table->string('pais', 45);
            $table->string('idProveedor', 10);

            $table->foreign('idProveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ubicacionFinca');
    }
}
