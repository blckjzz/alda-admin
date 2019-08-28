<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComandanteFKDelegadoIdToAbrangenciastable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abrangencias', function (Blueprint $table) {
            $table->foreign('comandante_id')->references('id')->on('comandantes');
            $table->foreign('delegado_id')->references('id')->on('delegados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abrangencias', function (Blueprint $table) {
            //
        });
    }
}
