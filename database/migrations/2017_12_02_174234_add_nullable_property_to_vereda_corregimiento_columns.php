<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablePropertyToVeredaCorregimientoColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ubicacionFinca', function (Blueprint $table) {
            $table->string('vereda', 60)->nullable()->change();
            $table->string('corregimiento', 60)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ubicacionFinca', function (Blueprint $table) {
            $table->string('vereda', 60)->change();
            $table->string('corregimiento', 60)->change();
        });
    }
}
