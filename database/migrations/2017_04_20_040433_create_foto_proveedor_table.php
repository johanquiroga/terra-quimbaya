<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotoProveedor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreArchivo', 45);
            $table->string('path');
            $table->string('idProveedor', 10);

            $table->foreign('idProveedor')->references('id')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fotoProveedor');
    }
}
