<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministradorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrador', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('correoElectronico', 45)->unique();
            $table->string('contraseña', 60);
            $table->string('telefono', 45);
            $table->boolean('estado')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('administrador');
    }
}
