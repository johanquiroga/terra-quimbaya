<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablePropertyToValorAtributoColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compradorTienePreferencia', function (Blueprint $table) {
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
        Schema::table('compradorTienePreferencia', function (Blueprint $table) {
	        $table->string('valorAtributo', 45)->change();
        });
    }
}
