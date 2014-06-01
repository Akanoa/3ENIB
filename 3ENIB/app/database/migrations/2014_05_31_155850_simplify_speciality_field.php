<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimplifySpecialityField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Schema::drop("specialities");
		if (Schema::hasColumn("students", "speciality")){
			Schema::table("students", function($table){
				$table->dropColumn("speciality");
			});
		}
		Schema::table("students", function($table){
			$table->string("speciality");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create("specialities", function($table){
			$table->string("name");
			$table->integer('id');
		});
		if (Schema::hasColumn("students", "speciality")){
			Schema::table("students", function($table){
				$table->dropColumn("speciality");
			});
		}
		Schema::table("students", function($table){
			$table->integer("speciality");
		});
	}

}
