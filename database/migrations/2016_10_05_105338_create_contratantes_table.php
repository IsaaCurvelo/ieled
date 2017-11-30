<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratantesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
	  Schema::create('contratantes', function (Blueprint $table) {
	  	$table->increments('id');
	    $table->string('nome');
	    $table->string('cnpj',18)->unique()->nullable();
	    $table->timestamps();
	  });

	  Schema::create('area_despesas', function (Blueprint $table) {
	  	$table->increments('id');
	    $table->string('nome')->unique();
	    $table->timestamps();
	  });
  	
	  Schema::create('tipo_despesas', function (Blueprint $table) {
	  	$table->increments('id');
	    $table->string('nome')->unique();
	    $table->timestamps();
	  });
	  
	  Schema::create('situacaos', function (Blueprint $table) {
	  	$table->increments('id');
	    $table->string('nome')->unique();
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
    Schema::dropIfExists('contratantes');
  }
}
