<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComandanteDelegadoIdToAbrangenciastable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abrangencias', function (Blueprint $table) {
            $table->integer('comandante_id')->nullable();
            $table->integer('delegado_id')->nullable();
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
