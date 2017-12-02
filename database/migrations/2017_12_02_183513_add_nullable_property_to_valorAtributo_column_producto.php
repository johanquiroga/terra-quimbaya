<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablePropertyToValorAtributoColumnProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productoTieneAtributo', function (Blueprint $table) {
            $table->string('valorAtributo', 45)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productoTieneAtributo', function (Blueprint $table) {
            $table->string('valorAtributo', 45)->change();
        });
    }
}
