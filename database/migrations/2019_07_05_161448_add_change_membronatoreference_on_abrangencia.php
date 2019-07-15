<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangeMembronatoreferenceOnAbrangencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abrangencias', function (Blueprint $table) {
            $table->integer('membronato_id')->unsigned()->change();
            $table->foreign('membronato_id')->references('id')->on('membrosnatos_abrangencia');
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
            $table->dropForeign('membronato_id');
        });
    }
}
