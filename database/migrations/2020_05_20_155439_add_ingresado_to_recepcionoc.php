<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIngresadoToRecepcionoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recepcionocs', function (Blueprint $table) {
            $table->integer('cantidadingoc')->nullable()->after('cantidaddococ');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recepcionocs', function (Blueprint $table) {
            $table->dropColumn('cantidadingoc');
            //
        });
    }
}
