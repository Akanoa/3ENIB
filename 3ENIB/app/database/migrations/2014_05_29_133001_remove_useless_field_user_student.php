<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUselessFieldUserStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("users", function($table){
			$table->dropColumn("lastname", "firstname");
		});

		if (Schema::hasColumn("students", "speciality"))
		{
			Schema::table("students", function($table){
				$table->dropColumn("speciality");
			});
		}

		Schema::table("students", function($table){
			$table->dropColumn("mail");
			$table->integer("speciality");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("users", function($table){
			$table->string("lastname");
			$table->string("firstname");
		});

		if (Schema::hasColumn("students", "speciality"))
		{
			Schema::table("students", function($table){
				$table->dropColumn("speciality");
			});
		}

		Schema::table("students", function($table){
			$table->string("mail");
			$table->integer("speciality");
		});

	}

}
