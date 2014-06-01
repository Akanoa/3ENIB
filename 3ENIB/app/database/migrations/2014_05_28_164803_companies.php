<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Companies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("companies", function($table){
			$table->increments('id');
			$table->string("name");
			$table->text("description");
			$table->string("photo_filepath");
			$table->text("contact");
			$table->string("expertise");
			$table->string("phone_number");
			$table->text("SIRET");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("companies");
	}

}
