<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fechaGeneracion')->useCurrent();
            $table->string('path');
            $table->string('idAdministrador', 10)->nullable();

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
        Schema::drop('informe');
    }
}
