<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompradorTienePreferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compradorTienePreferencia', function (Blueprint $table) {
            $table->string('idComprador', 10);
            $table->integer('idAtributo')->unsigned();
            $table->string('valorAtributo', 45);

            $table->primary(['idComprador', 'idAtributo']);
            $table->foreign('idComprador')->references('id')->on('comprador')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idAtributo')->references('id')->on('atributo')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('compradorTienePreferencia');
    }
}
