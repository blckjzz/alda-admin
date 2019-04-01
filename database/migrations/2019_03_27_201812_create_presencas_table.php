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
        Schema::create('presenca_reuniao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agenda_id');
            $table->text('membrosnato');
            $table->text('diretoria');
            $table->timestamps();
        });

        Schema::table('presenca_reuniao', function (Blueprint $table){
            $table->foreign('agenda_id')
                ->references('id')
                ->on('agendas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presenca_reuniao');
    }
}
