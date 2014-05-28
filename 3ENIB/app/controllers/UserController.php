<?php

class UserController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth', array('only' => array('signup', 'signout')));
		$this->beforeFilter('csrf', array('on' => 'post'));
	}


	/**
	 * Display signup form
	 *
	 * @return Response
	 */
	public function getSignup()
	{
		$specialities = Speciality::all();
		$headerTitle = "S'inscrire";
		return View::make("user.signup")
			->with("headerTitle", $headerTitle)
			->with("specialities", $specialities);
	}

	/**
	 * Create a new user if datas are valids
	 *
	 * @return Response
	 */
	public function postSignup()
	{
		if(Auth::check()){return Redirect::to("/");}

		$rules = array(
				"firstname"=>"required|between:2,20",
				"lastname"=>"required|between:2,20",
				"email"=>"required|email",
				"password"=>"required|min:5|confirmed",
				"password_confirmation"=>"required|"
			);

		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails()){
			return Redirect::to("user/signup")
				->withErrors($validation)
				->withInput();
		}
		else
		{

			$skills = 0;
			foreach (Input::get("specialities") as $skill) {
				$skills += intval($skill);
			}

			$data_student = array(
					"lastname"=>Input::get("lastname"),
					"firstname"=>Input::get("firstname"),
					"phone_number"=>Input::get("phone_number"),
					"description"=>Input::get("description"),
					"speciality"=>$skills
				);

			$id_student = DB::table('students')->insertGetId($data_student);

			$data_user = array(
					"email"=> Input::get("email"),
					"password"=> Hash::make(Input::get("password")),
					"own_type"=> Input::get("subscription_type"),
					"own_id"=>$id_student,
					"created_at"=>date("Y-m-d H:i:s"),
					"updated_at"=>date("Y-m-d H:i:s")
				);

			DB::table('users')->insertGetId($data_user);
		}

	}

	/**
	 * log in an existing user.
	 *
	 * @return Response
	 */
	public function getSignin()
	{
		echo "Welcome you";
	}






}
