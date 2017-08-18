<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotoProducto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreArchivo', 45);
            $table->string('path');
            $table->integer('idProducto')->unsigned();

            $table->foreign('idProducto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fotoProducto');
    }
}
