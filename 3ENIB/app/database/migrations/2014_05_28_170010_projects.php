<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("projects", function($table){
			$table->increments('id');
			$table->string("name");
			$table->enum('state', array('recruitment
', 'in progress', 'finish'));
			$table->string("require_skills");
			$table->integer("student_id");
			$table->integer("company_id");
			$table->text("description");
			$table->string("document_id");
			$table->float("remuneration");
			$table->string("estimated_time");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("projects");
	}

}
