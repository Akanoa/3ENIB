<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
	}

}


class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create([
        				"own_type"=>"student",
        				"own_id"=>1,
        				"password"=>"$2y$10$2VfKiAFOvelllPPygcChTu5Ic1wx1PaKevmD45Qw/83ULr3YDTX2C",
        				'email' => '3enib@enib.fr',
        				'admin'=>1
        			]);

        DB::table('students')->delete();

        Student::create([
        					"firstname"=>"Admin",
        					"user_id"=>1,
        					"phone_number"=>"&nbsp;",
        					"RIB"=>"&nbsp;"
        				]);
    }

}