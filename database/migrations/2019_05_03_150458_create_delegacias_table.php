<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelegaciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegacias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('delegacia')->nullable();
            $table->string('municipio')->nullable();
            $table->string('abrangencia')->nullable();
            $table->string('meta_abrangencia')->nullable();
            $table->string('endereco')->nullable();
            $table->string('telefone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delegacias');
    }
}
