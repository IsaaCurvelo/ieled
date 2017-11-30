<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCascadeToAllTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inscricaos', function($table) {

			$table->dropForeign('inscricaos_user_id_foreign');

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


		});

		Schema::table('ocorrencias', function($table) {

			$table->dropForeign('ocorrencias_user_id_foreign');

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
				
		});


		Schema::table('notificacaos', function($table) {

            $table->dropForeign('notificacaos_ocorrencia_id_foreign');

            $table->foreign('ocorrencia_id')->references('id')->on('ocorrencias')->onDelete('cascade');
			
				
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('inscricaos', function($table) {

			$table->dropForeign('inscricaos_user_id_foreign');

			$table->foreign('user_id')->references('id')->on('users');

		});
	
		Schema::table('ocorrencias', function($table) {

			$table->dropForeign('ocorrencias_user_id_foreign');

			$table->foreign('user_id')->references('id')->on('users');

		});


		Schema::table('notificacaos', function($table) {

			$table->dropForeign('notificacaos_ocorrencia_id_foreign');

            $table->foreign('ocorrencia_id')->references('id')->on('ocorrencias');

		});

	}
}
