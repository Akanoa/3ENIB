<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimestampsStudentsCompanies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("students", function($table){
			$table->timestamps();
		});

		Schema::table("companies", function($table){
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
		Schema::table("students", function($table){
			$table->dropColumn("updated_at");
			$table->dropColumn("created_at");
		});

		Schema::table("companies", function($table){
			$table->dropColumn("updated_at");
			$table->dropColumn("created_at");
		});
	}

}
