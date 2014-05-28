<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateCompanysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop("companys");
		Schema::create("companys", function($table){
			$table->increments('id');
			$table->string("name");
			$table->text("description");
			$table->string("photo_filepath");
			$table->string("adress");
			$table->text("contact");
			$table->string("expertise");
			$table->string("phone_number");
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
		Schema::create("companys", function($table){
			$table->increments('id');
			$table->string("name");
			$table->text("description");
			$table->string("photo_filepath");
			$table->string("adress");
			$table->text("contact");
			$table->string("expertise");
			$table->string("phone_number");
			$table->string("SIRET");
		});
	}

}
