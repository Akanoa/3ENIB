<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Students extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("students", function($table){
			$table->increments('id');
			$table->string("lastname");
			$table->string("firstname");
			$table->string("speciality");
			$table->string("photo_filepath");
			$table->string("mail");
			$table->string("phone_number");
			$table->string("cv_filepath");
			$table->text("description");
			$table->text("RIB");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("students");
	}

}
