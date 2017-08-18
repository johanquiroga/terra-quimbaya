<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idProducto')->unsigned();
            $table->string('idComprador', 10);
            $table->integer('cantidad')->unsigned();
            $table->decimal('valorTotal', 8, 2);
	        $table->string('idOrden', 10)->unique();
            $table->timestamp('fechaDeCompra')->useCurrent();
            $table->integer('idMetodoPago')->unsigned();
            $table->integer('idEstadoCompra')->unsigned();

            $table->foreign('idProducto')->references('id')->on('producto')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idComprador')->references('id')->on('comprador')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idMetodoPago')->references('id')->on('metodoPago')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idEstadoCompra')->references('id')->on('estadoCompra')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('compra');
    }
}
