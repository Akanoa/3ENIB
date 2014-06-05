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
				//generate hash verification mail
				$hash = md5(strval(time()));


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
						"hash_verification"=>$hash,
						"created_at"=>date("Y-m-d H:i:s"),
						"updated_at"=>date("Y-m-d H:i:s")
					);

				$user_id = DB::table('users')->insertGetId($data_user);

				if(Input::hasFile("avatar"))
				{
					$avatar = Input::file("avatar");
					$filepath = "/uploads/".$user_id."/avatar/".md5($avatar->getClientOriginalName());
					$avatar->move(storage_path()."/uploads/".$user_id."/avatar/", md5($avatar->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->photo_filepath = $filepath;
					$student->save();
				}

				if(Input::hasFile("cv"))
				{
					$cv = Input::file("cv");
					$filepath = "/uploads/".$user_id."/cv/".md5($cv->getClientOriginalName());
					$cv->move(storage_path()."/uploads/".$user_id."/cv/", md5($cv->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->cv_filepath = $filepath;
					$student->save();
				}

				$data = [
						"id"=>$user_id,
						"lastname"=>Input::get("lastname"),
						"firstname"=>Input::get("firstname"),
						"hash"=>$hash
						];

				Mail::send("emails.account.verification_student", $data, function($message){
						$message->from("subscription@3enib.fr");
						$message->to("y0guern@enib.fr")->subject("Vérification email 3ENIB");
					});


			}
		}

		else if(Input::get("subscription_type")=="company")
		{

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
				$valid = true;
				$errors_ = [];
				$credentials = ['email' => Input::get("email"), 'password' => Input::get("password")];

				if (Auth::validate($credentials))
				{
					$user = User::where("email", "=", $credentials["email"])->first();
					if($user->hash_verification!=''){
						array_push($errors_, "Vous n'avez pas encore confirmé votre email, vérifiez votre boîte mail");
						$valid = false;
					}
					if($user->active!=1){
						array_push($errors_, "Ce compte n'est pas actif, il a soit été banni soit désactivé momentanément");
						$valid = false;
					}
				}
				else
				{
					$valid = false;
					array_push($errors_, "Le couple mot de passe/email ne correspond pas");
				}

				if($valid)
				{
					Auth::attempt($credentials, true, true);
					return Redirect::to("/");
				}
				else
				{
					return Redirect::to("user/signin")
					->with("notifications_errors",$errors_)
					->with("headerTitle","Connection error")
					->withInput();
				}

			}
	}

	/**
	 * handle log out an existing user.
	 *
	 * @return Response
	 */
	public function getSignout()
	{
		if(Auth::check())
		{
			Auth::logout();
		}
		return Redirect::to("/");
	}

	/**
	 * verification of email's user.
	 *
	 * @return Response
	 */
	public function getVerification($id, $hash)
	{
		try 
		{
			$user = User::find($id);
			if($user->hash_verification == $hash)
			{
				$user->hash_verification = "";
				$user->save();
				return Redirect::to("user/signin")
					->with('notifications_success', ["Votre mail est désormais validé, vous pouvez vous connecter."]);
			}
			else if($user->hash_verification == "")
			{
				return Redirect::to("user/signin")
					->with('notifications_infos', ["Ce mail a déjà été validé, vous pouvez vous connecter."]);
			}
			else
			{
				return Redirect::to("user/signin")
					->with('notifications_errors', ["Ce mail n'existe pas."]);
			}
		} 
		catch (Exception $e) 
		{
			return Redirect::to("user/signin")
				->with('notifications_errors', ["L'utilisateur n'existe pas."]);
		}
	}
}
