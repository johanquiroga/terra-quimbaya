<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idTipoSolicitud')->unsigned();
            $table->string('idComprador', 10);
            $table->string('idAdministrador', 10);
            $table->text('mensaje');
            $table->text('respuesta')->nullable();
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
            $table->bigInteger('requestable_id')->unsigned();
            $table->string('requestable_type');
            $table->boolean('leidoAdmin')->default(false);
            $table->boolean('leidoComprador')->default(false);
            $table->timestamps();

            $table->foreign('idTipoSolicitud')->references('id')->on('tipoSolicitud')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idComprador')->references('id')->on('comprador')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idAdministrador')->references('id')->on('administrador')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solicitud');
    }
}
