<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompradorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprador', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('correoElectronico', 45)->unique();
            $table->string('contraseña', 60);
            $table->string('telefono', 45);
            $table->integer('idFrecuenciaCompraCafe')->unsigned();
            $table->integer('idNivelEstudios')->unsigned();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->foreign('idFrecuenciaCompraCafe')->references('id')->on('frecuenciaCompraCafe')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idNivelEstudios')->references('id')->on('nivelEstudios')
                ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comprador');
    }
}
