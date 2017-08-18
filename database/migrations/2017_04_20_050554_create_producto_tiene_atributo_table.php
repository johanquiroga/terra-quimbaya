<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTieneAtributoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productoTieneAtributo', function (Blueprint $table) {
            $table->integer('idProducto')->unsigned();
            $table->integer('idAtributo')->unsigned();
            $table->string('valorAtributo', 45);

            $table->primary(['idProducto', 'idAtributo']);
            $table->foreign('idProducto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('productoTieneAtributo');
    }
}
