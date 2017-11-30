<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcorrenciasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ocorrencias', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned()->index();
      $table->integer('empresa_id')->unsigned()->index();
      $table->integer('situacao_id')->unsigned()->index();
      $table->integer('contratante_id')->unsigned()->index();
      $table->date('data');

      $table->integer('tipo_despesa_id')->unsigned()->index()->nullable();
      $table->integer('area_despesa_id')->unsigned()->index()->nullable();
      $table->string('valor')->nullable();
      $table->string('procedimento', 240)->nullable();

      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('empresa_id')->references('id')->on('empresas');
      $table->foreign('situacao_id')->references('id')->on('situacaos');
      $table->foreign('contratante_id')->references('id')->on('contratantes');
      $table->foreign('tipo_despesa_id')->references('id')->on('tipo_despesas');
      $table->foreign('area_despesa_id')->references('id')->on('area_despesas');

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
    Schema::dropIfExists('ocorrencias');
  }
}