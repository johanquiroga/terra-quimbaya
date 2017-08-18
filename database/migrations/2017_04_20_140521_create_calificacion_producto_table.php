<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacionProducto', function (Blueprint $table) {
	        $table->increments('id');
	        $table->bigInteger('idCompra')->unsigned();
	        $table->decimal('calificacion', 2, 1);
	        $table->text('comentario')->nullable();
            $table->timestamps();

            $table->foreign('idCompra')->references('id')->on('compra')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calificacionProducto');
    }
}
