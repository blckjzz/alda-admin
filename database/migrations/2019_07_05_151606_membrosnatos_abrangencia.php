<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MembrosnatosAbrangencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membrosnatos_abrangencia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comandante_id');
            $table->integer('delegado_id');

        });


        Schema::table('membrosnatos_abrangencia', function (Blueprint $table) {
            $table->foreign('comandante_id')->references('id')->on('membros_natos')->nullable();
            $table->foreign('delegado_id')->references('id')->on('membros_natos')->nullable();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membrosnatos_abrangencia', function (Blueprint $table) {
            //
        });
    }
}
