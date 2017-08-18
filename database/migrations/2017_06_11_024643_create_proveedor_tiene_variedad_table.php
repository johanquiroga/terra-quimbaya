<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorTieneVariedadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedorTieneVariedad', function (Blueprint $table) {
	        $table->string('idProveedor', 10);
	        $table->integer('idVariedadCafe')->unsigned();

	        $table->primary(['idProveedor', 'idVariedadCafe']);
	        $table->foreign('idProveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');
	        $table->foreign('idVariedadCafe')->references('id')->on('variedadCafe')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proveedorTieneVariedad');
    }
}
