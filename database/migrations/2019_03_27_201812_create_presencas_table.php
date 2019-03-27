<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presenca_reuniao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('membronato_id');
            $table->unsignedInteger('agenda_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presenca_reuniao', function (Blueprint $table) {
            //
        });
    }
}
