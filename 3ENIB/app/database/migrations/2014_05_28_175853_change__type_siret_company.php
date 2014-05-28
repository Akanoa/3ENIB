<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeSiretCompany extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	if (Schema::hasColumn('companies', 'SIRET'))
	{
		Schema::table("companies", function($table){
			$table->dropColumn('SIRET');
		});
	}
		Schema::table("companies", function($table){
			$table->string("SIRET");
		});
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("companies", function($table){
			$table->dropColumn('SIRET');
			$table->text("SIRET");
		});
	}

}
