<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Refazer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('orgao_investigadors', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nome')->unique();
          $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('email')->unique();
          $table->string('password');
          $table->integer('orgao_investigador_id')->unsigned()->index();
          $table->string('telefone')->unique()->nullable();
          $table->foreign('orgao_investigador_id')->references('id')->on('orgao_investigadors');
          $table->rememberToken();
          $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
          $table->string('email')->index();
          $table->string('token')->index();
          $table->timestamp('created_at')->nullable();
        });

        Schema::create('empresas', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nome');
          $table->string('cnpj',18)->unique()->nullable();
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
      
      Schema::dropIfExists('users');
    	Schema::dropIfExists('orgao_investigadors');
      Schema::dropIfExists('empresas');
      Schema::dropIfExists('password_resets');
    }
}
