<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presenca_reuniao', function (Blueprint $table) {
            $table->string('comandante_id')->nullable();
            $table->string('delegado_id')->nullable();
            $table->dropColumn('membrosnato');
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
            $table->dropColumn('comandante_id');
            $table->dropColumn('delegado_id');
            $table->integer('membrosnato');
        });
    }
}
