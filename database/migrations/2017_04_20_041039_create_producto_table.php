<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idVariedadCafe')->unsigned();
            $table->string('nombre')->unique();
	        $table->string('descripcion');
            $table->integer('cantidad')->unsigned();
            $table->decimal('precioEmpaque', 8, 2);
            $table->decimal('calificacion', 2, 1)->default(0.0);
            $table->string('idPublicacion', 10)->unique();
            $table->string('idProveedor', 10);
            $table->string('idAdministrador', 10)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->foreign('idVariedadCafe')->references('id')->on('variedadCafe')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('idProveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idAdministrador')->references('id')->on('administrador')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('producto');
    }
}
