<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablePropertyToDireccionAuxiliar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direccionResidencia', function (Blueprint $table) {
	        $table->string('direccionAuxiliar', 60)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direccionResidencia', function (Blueprint $table) {
	        $table->string('direccionAuxiliar', 60)->change();
        });
    }
}
