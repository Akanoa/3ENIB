<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Migration.0.1 extends Migration {

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
			$table->string("SIRET");
			$table->string("avatar_filepath");
			$table->integer("user_id");
			$table->timestamps();
		});

		Schema::create("documents", function($table){
			$table->increments('id');
			$table->string("path");
			$table->string("name");
			$table->timestamps();
		});

		Schema::create("passoword_reminders", function($table){
			$table->string("email")->index();
			$table->string("token")->index();
			$table->timestamps();
		});

		Schema::create("posts", function($table){
			$table->increments('id');
			$table->integer('project_id');
			$table->integer("user_id");
			$table->text("message");
			$table->integer("state");
			$table->timestamps();
		});

		Schema::create("projects", function($table){
			$table->increments('id');
			$table->string("name");
			$table->string("required_skills");
			$table->integer('company_id');
			$table->text("description");
			$table->float("remuneration");
			$table->string("estimated_time");
			$table->integer("state");
			$table->timestamps();
		});

		Schema::create("project_student_pivot", function($table){
			$table->increments("id");
			$table->string("project_id");
			$table->string("student_id");
			$table->integer("student_state")->default(0);
			$table->timestamps();
		});

		Schema::create("students", function($table){
			$table->increments('id');
			$table->string("lastname");
			$table->string("firstname");
			$table->string("speciality");
			$table->string("photo_filepath");
			$table->string("phone_number");
			$table->string("avatar_filepath");
			$table->string("cv_filepath");
			$table->text("description");
			$table->string("RIB");
			$table->integer("user_id");
			$table->timestamps();
		});

		Schema::create("users", function($table){
			$table->increments('id');
			$table->string('email', 100)->unique();
			$table->string('password', 64);
			$table->integer("own_id");
			$table->string("own_type");
			$table->timestamps();
			$table->integer("admin")->default(0);
			$table->string("hash_verification");
			$table->string("remember_token");
			$table->integer("active")->default(1);
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
		Schema::drop("documents");
		Schema::drop("passoword_reminders");
		Schema::drop("posts");
		Schema::drop("projects");
		Schema::drop("project_student_pivot");
		Schema::drop("students");
		Schema::drop("users");

	}

}
