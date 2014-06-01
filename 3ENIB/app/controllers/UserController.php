<?php

class UserController extends BaseController 
{

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
		$studentSpecialities = [
			"Mecatronique",
			"Informatique",
			"Électronique"
		];
		$headerTitle = "S'inscrire";

		return View::make("user.signup", compact(["headerTitle", "studentSpecialities"]));
	}

	/**
	 * Create a new user if datas are valids
	 *
	 * @return Response
	 */
	public function postSignup()
	{
		if(Auth::check()){return Redirect::to("/");}


		if(Input::get("subscription_type")=="student")
		{

			$rules = array(
					"firstname"=>"required|between:2,20",
					"lastname"=>"required|between:2,20",
					"email"=>"required|email|unique:users|enib_email",
					"avatar"=>"image|mimes:jpeg,bmp,png",
					"cv"=>"mimes:pdf",
					"password"=>"required|min:5|confirmed",
					"password_confirmation"=>"required"
				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()){
				return Redirect::to("user/signup")
					->withErrors($validation)
					->withInput();
			}
			else
			{
				$speciality = "";
				if(Input::get("specialities") != null)
				{
					$speciality = implode(", ", Input::get("specialities"));
				}

				$data_student = array(
						"lastname"=>Input::get("lastname"),
						"firstname"=>Input::get("firstname"),
						"phone_number"=>Input::get("phone_number"),
						"description"=>Input::get("description"),
						"speciality"=>$speciality
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

				$user_id = DB::table('users')->insertGetId($data_user);

				if(Input::hasFile("avatar"))
				{
					$avatar = Input::file("avatar");
					$filepath = storage_path()."/uploads/".$user_id."/avatar/".md5($avatar->getClientOriginalName());
					$avatar->move($filepath);
					$student = User::find($user_id)->own;
					$student->photo_filepath = $filepath;
					$student->save();
				}

				if(Input::hasFile("cv"))
				{
					$cv = Input::file("cv");
					$filepath = storage_path()."/uploads/".$user_id."/cv/".md5($avatar->getClientOriginalName());
					$cv->move(storage_path()."/uploads/".$user_id."/cv/", md5($avatar->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->photo_filepath = $filepath;
					$student->save();
				}


			}
		}

	}

	/**
	 * log in an existing user.
	 *
	 * @return Response
	 */
	public function getSignin()
	{
		$headerTitle = "Connection";
		return View::make("user.signin", compact("headerTitle"));
	}

	/**
	 * handle log in an existing user.
	 *
	 * @return Response
	 */
	public function postSignin()
	{

			$rules = array(
					"email"=>"required|email",
					"password"=>"required",
				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()){
				return Redirect::to("user/signin")
					->withErrors($validation)
					->withInput();
			}
			else
			{

				if (Auth::attempt(['email' => Input::get("email"), 'password' => Input::get("password"), 'active' => 1], false, false))
				{
				    $user = User::where("email", "=", Input::get("email"))->first();
				    var_dump($user->hash_verification);
				}
			}
	}
}
