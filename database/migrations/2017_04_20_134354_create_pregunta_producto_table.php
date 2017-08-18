<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntaProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntaProducto', function (Blueprint $table) {
	        $table->increments('id');
        	$table->string('idComprador', 10);
	        $table->integer('idProducto')->unsigned();
	        $table->text('consulta');
	        $table->text('respuesta')->nullable();
            $table->timestamps();

            $table->foreign('idComprador')->references('id')->on('comprador')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idProducto')->references('id')->on('producto')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('preguntaProducto');
    }
}
