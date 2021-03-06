<?php

class UserController extends BaseController 
{

	public function __construct()
	{
		$this->beforeFilter('auth', array('only' => array('signout', 'edit', 'ban', 'unban')));
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
		Session::set("headerTitle", "S'inscrire");

		return View::make("user.signup", compact("studentSpecialities"));
	}

	/**
	 * Create a new user if datas are valids
	 *
	 * @return Response
	 */
	public function postSignup()
	{
		if(Auth::check())
		{
			Session::set("headerTitle", "Acceuil");
			return Redirect::to("/");
		}


		if(Input::get("subscription_type")=="student")
		{

			$rules = array(
					"firstname"=>"required|between:2,50",
					"lastname"=>"required|between:2,20",
					"email"=>"required|email|unique:users|enib_email",
					"avatar"=>"image|mimes:jpeg,png,tga",
					"photo"=>"image|mimes:jpeg,png,tga",
					"cv"=>"mimes:pdf",
					"password"=>"required|min:5|confirmed",
					"password_confirmation"=>"required",
					"secu"=>"required"
				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()){
				Session::set("headerTitle", "Se connecter");
				return Redirect::to("user/signup")
					->withErrors($validation)
					->withInput()
					->with("signup-type", "student");
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
						"lastname"=>Input::get("lastname", ""),
						"firstname"=>Input::get("firstname", ""),
						"secu"=>Input::get("secu", ""),
						"phone_number"=>Input::get("phone_number")!=""?:"&nbsp;",
						"description"=>Input::get("description", ""),
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

				Student::where("id", "=", $id_student)->update(["user_id"=>$user_id]);

				if(Input::hasFile("avatar"))
				{
					$avatar = Input::file("avatar");
					$hash_avatar = md5($avatar->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/avatar/".$hash_avatar;
					$avatar->move(storage_path()."/uploads/".$user_id."/avatar/", md5($avatar->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->avatar_filepath = $hash_avatar;
					$student->save();
				}

				if(Input::hasFile("photo"))
				{
					$photo = Input::file("photo");
					$hash_photo = md5($photo->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/photo/".$hash_photo;
					$photo->move(storage_path()."/uploads/".$user_id."/photo/", md5($photo->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->photo_filepath = $hash_photo;
					$student->save();
				}

				if(Input::hasFile("cv"))
				{
					$cv = Input::file("cv");
					$hash_cv = md5($cv->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/cv/".$hash_cv;
					$cv->move(storage_path()."/uploads/".$user_id."/cv/", md5($cv->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->cv_filepath = $hash_cv;
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
						$message->to(Input::get("email"))->subject("Vérification email 3ENIB");
					});

				return Redirect::to('/')
					->with("notifications_infos", ["Un email vous a été envoyé"]);
			}
		}

		else if(Input::get("subscription_type")=="company")
		{
			$rules = array(
					"name"=>"required|between:2,50",
					"email"=>"required|email|unique:users",
					"avatar"=>"image|mimes:jpeg,png,tga",
					"image"=>"image|mimes:jpeg,png,tga",
					"password"=>"required|min:5|confirmed",
					"password_confirmation"=>"required",
					"contact"=>"required",
					"siret"=>"required"
				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()){
				Session::set("headerTitle", "Se connecter");
				return Redirect::to("user/signup")
					->withErrors($validation)
					->withInput()
					->with("signup-type", "company");
			}
			else
			{
				//generate hash verification mail
				$hash = md5(strval(time()));

				$data_company = array(
						"name"=>Input::get("name"),
						"siret"=>Input::get("siret"),
						"phone_number"=>Input::get("phone_number")!=""?:"&nbsp;",
						"contact"=>Input::get("contact"),
						"expertise"=>Input::get("expertise"),
						"description"=>Input::get("description"),
					);


				$id_company = DB::table('companies')->insertGetId($data_company);

				$data_user = array(
						"email"=> Input::get("email"),
						"password"=> Hash::make(Input::get("password")),
						"own_type"=> Input::get("subscription_type"),
						"own_id"=>$id_company,
						"hash_verification"=>$hash,
						"created_at"=>date("Y-m-d H:i:s"),
						"updated_at"=>date("Y-m-d H:i:s")
					);

				$user_id = DB::table('users')->insertGetId($data_user);

				Company::where("id", "=", $id_company)->update(["user_id"=>$user_id]);

				if(Input::hasFile("avatar"))
				{
					$avatar = Input::file("avatar");
					$hash_avatar = md5($avatar->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/avatar/".$hash_avatar;
					$avatar->move(storage_path()."/uploads/".$user_id."/avatar/", md5($avatar->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->avatar_filepath = $hash_avatar;
					$student->save();
				}

				if(Input::hasFile("logo"))
				{
					$logo = Input::file("logo");
					$hash_logo = md5($logo->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/logo/".$hash_logo;
					$logo->move(storage_path()."/uploads/".$user_id."/logo/", md5($logo->getClientOriginalName()));
					$company = User::find($user_id)->own;
					$company->photo_filepath = $hash_logo;
					$company->save();
				}

				$data = [
						"id"=>$user_id,
						"hash"=>$hash
						];

				Mail::send("emails.account.verification_company", $data, function($message){
						$message->from("subscription@3enib.fr");
						$message->to(Input::get("email"))->subject("Vérification email 3ENIB");
					});

				return Redirect::to('/')
					->with("notifications_infos", ["Un email vous a été envoyé"]);
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
		if(Auth::check())
		{
			Session::set("headerTitle", "Accueil");
			$infos = ["Vous êtes déjà connecté"];
			return Redirect::to("/")
				->with("notifications_infos", $infos);

		}
		Session::set("headerTitle", "Se connecter");
		return View::make("user.signin");
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
				Session::set("headerTitle", "Se connecter");
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
					Session::set("headerTitle", "Acceuil");

					$infos = ["Vous êtes maintenant connecté"];

					return Redirect::to("/")
						->with("notifications_success", $infos);
				}
				else
				{
					Session::set("headerTitle", "Se connecter");
					return Redirect::to("user/signin")
					->with("notifications_errors",$errors_)
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
		Session::set("headerTitle", "Se connecter");
		$infos = ["Vous êtes maintenant déconnecté"];
		return Redirect::to("/")
			->with("notifications_infos", $infos);
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

	/**
	 * edition an existing user.
	 *
	 * @return Response
	 */
	 public function getEdit($user_id=0)
	 {
	 	if(Auth::check())
	 	{
	 		if(App::make("3enib_authz")->isAdmin() and $user_id!=0)
	 		{
	 			$user = User::find($user_id);
	 		}
	 		else
	 		{
	 			$user = Auth::user(); 
	 		}
			Session::set("headerTitle", "Edition");
			$type = $user->own_type;

			if($type == "student")
			{
				$studentSpecialities = [
					"Mecatronique",
					"Informatique",
					"Électronique"
				];


				$datas = [
					"lastname" => $user->own->lastname,
					"firstname" => $user->own->firstname,
					"email" => $user->email,
					"phone_number" => $user->own->phone_number,
					"description" => $user->own->description,
					"secu" => $user->own->secu
				];

				return View::make("user.edit", compact("user", "studentSpecialities", "datas"));
				
			}
			else if($type == "company")
			{

				$datas = [
					"name" => $user->own->name,
					"siret" => $user->own->SIRET,
					"email" => $user->email,
					"phone_number" => $user->own->phone_number,
					"description" => $user->own->description,
					"expertise" => $user->own->expertise,
					"contact" => $user->own->contact
				];

				return View::make("user.edit", compact("user", "datas"));
			}
	 	}
	 	else
	 	{
	 		Session::set("headerTitle", "Accueil");
			return Redirect::to("/");
	 	}
	 }

	/**
	* edition an existing user.
	*
	* @return Response
	*/
	public function postEdit()
	{
		if(!Auth::check())
		{
			Session::set("headerTitle", "Accueil");
			return Redirect::to("/");
		}

		$admin = App::make("3enib_authz")->isAdmin();

		if($admin)
		{
			$user_id = Input::get("user_id");
			$user = User::find($user_id);
		}
		else
		{
			$user = Auth::user();
			$user_id = $user->id;
		}	

		if(Input::get("subscription_type")=="student")
		{

			$rules = array(
					"firstname"=>"between:2,50",
					"lastname"=>"between:2,20",
					"email"=>"email|enib_email",
					"avatar"=>"image|mimes:jpeg,png,tga",
					"photo"=>"image|mimes:jpeg,png,tga",
					"cv"=>"mimes:pdf",
					"password"=>"min:5|confirmed",
					"secu"=>"required"
				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				Session::set("headerTitle", "Se connecter");
				return Redirect::to("user/edit")
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
						"secu"=>Input::get("secu")
					);

				if($speciality != "")
				{
					$data_student["speciality"] = $speciality;
				}


				Student::where("id", '=', $user->own->id)->update($data_student);

				$data_user = array(
						"email"=> Input::get("email"),
					);

				if(Input::get("password"))
				{
					$data_user["password"] = Hash::make(Input::get("password"));
				}

				User::where("id",'=',$user_id)->update($data_user);

				if(Input::all()["avatar"]!=null)
				{
					$avatar = Input::file("avatar");
					$hash_avatar = md5($avatar->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/avatar/".$hash_avatar;
					$avatar->move(storage_path()."/uploads/".$user_id."/avatar/", md5($avatar->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->avatar_filepath = $hash_avatar;
					$student->save();
				}

				if(Input::all()["photo"]!=null)
				{
					$photo = Input::file("photo");
					$hash_photo = md5($photo->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/photo/".$hash_photo;
					$photo->move(storage_path()."/uploads/".$user_id."/photo/", md5($photo->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->photo_filepath = $hash_photo;
					$student->save();
				}


				if(Input::all()["cv"]!=null)
				{
					$cv = Input::file("cv");
					$hash_cv = md5($cv->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/pdf/".$hash_cv;
					$cv->move(storage_path()."/uploads/".$user_id."/pdf/", md5($cv->getClientOriginalName()));
					$student = User::find($user_id)->own;
					$student->cv_filepath = $hash_cv;
					$student->save();
				}
			}
		}

		else if(Input::get("subscription_type")=="company")
		{
			$rules = array(
					"name"=>"between:2,50",
					"email"=>"email",
					"avatar"=>"image|mimes:jpeg,png,tga",
					"image"=>"image|mimes:jpeg,png,tga",
					"password"=>"min:5|confirmed",
				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				return Redirect::to("user/edit")
					->withErrors($validation)
					->withInput();
			}
			else
			{

				$data_company = array(
						"name"=>Input::get("name"),
						"siret"=>Input::get("siret"),
						"phone_number"=>Input::get("phone_number"),
						"contact"=>Input::get("contact"),
						"expertise"=>Input::get("expertise"),
						"description"=>Input::get("description"),
					);


				Company::where("id", '=', $user->own->id)->update($data_company);

				$data_user = array(
						"email"=> Input::get("email"),
					);
				if(Input::get("password"))
				{
					$data_user["password"] = Hash::make(Input::get("password"));
				}

				User::where("id",'=',$user_id)->update($data_user);

				if(Input::all()["avatar"]!=null)
				{
					$avatar = Input::file("avatar");
					$hash_avatar = md5($avatar->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/avatar/".$hash_avatar;
					$avatar->move(storage_path()."/uploads/".$user_id."/avatar/", md5($avatar->getClientOriginalName()));
					$company = User::find($user_id)->own;
					$company->avatar_filepath = $hash_avatar;
					$company->save();
				}

				if(Input::all()["logo"]!=null)
				{
					$logo = Input::file("logo");
					$hash_logo = md5($logo->getClientOriginalName());
					$filepath = "/uploads/".$user_id."/logo/".$hash_logo;
					$logo->move(storage_path()."/uploads/".$user_id."/logo/", md5($logo->getClientOriginalName()));
					$company = User::find($user_id)->own;
					$company->photo_filepath = $hash_logo;
					$company->save();
				}
			}
		}
		
		Session::set("headerTitle", "edition");
		$infos = ["Votre profil à été édité."];

		if($admin)
		{
			return Redirect::to("/user/edit/".$user_id)
				->with("notifications_infos", $infos);
		}
		else
		{
			return Redirect::to("/user/edit")
				->with("notifications_infos", $infos);
		}		

	}

	public function postUnban()
	{
		if(!App::make("3enib_authz")->isAdmin())
		{
			return Redirect::to("/user/list")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire cela"]);
		}

		$user_id = Input::get("user_id", 0);

		if($user_id == 0)
		{
			return Redirect::to("/user/list")
				->with("notifications_errors", ["L'utilisateur n'existe pas"]);
		}

		$user = User::find($user_id);

		$user->active = 1;

		$user->save();

		$final="";

		if($user->own_type == "student")
		{
			$location = "student/list";
			$own = "étudiant";
			$name = $user->own->firstname." ".$user->own->lastname;
		}
		else
		{
			$location = "company";
			$own = "entreprise";
			$name = $user->own->name;
			$final="e";
		}

		return Redirect::to($location)
			->with("notifications_infos", ["L'$own <b>$name</b> n'est plus banni$final"]);


	}

	public function postBan()
	{
		if(!App::make("3enib_authz")->isAdmin())
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire cela"]);
		}

		$user_id = Input::get("user_id", 0);

		if($user_id == 0)
		{
			return Redirect::to("/")
				->with("notifications_errors", ["L'utilisateur n'existe pas"]);
		}

		$user = User::find($user_id);

		$user->active = 0;

		$user->save();

		$final="";

		if($user->own_type == "student")
		{
			$location = "student/list";
			$own = "étudiant";
			$name = $user->own->firstname." ".$user->own->lastname;
		}
		else
		{
			$location = "company";
			$own = "entreprise";
			$name = $user->own->name;
			$final="e";
		}

		return Redirect::to($location)
			->with("notifications_infos", ["L'$own <b>$name</b> est banni$final"]);
	}

	public function getDestroyNotification($notif_id)
	{
		$notif = Notification::find($notif_id); 
		if(Auth::user()->id != $notif->recipient_id)
			return false;
		$notif->delete();
	}


	public function postElevate()
	{
		if(!App::make("3enib_authz")->isAdmin())
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire cela"]);
		}

		$user_id = Input::get("user_id", 0);

		if($user_id != 0)
		{
			$user = User::find($user_id);
			$user->admin = 1;
			$user->save();

		return Redirect::to("student/list")
			->with("notifications_infos", ["L'étudiant <b>".$user->firstname." ".$user->lastname."</b> est désormais administrateur"]);
		}
			return Redirect::to("/")
				->with("notifications_errors", ["L'utilisateur n'existe pas"]);
	}

	public function postRetrograde()
	{
		if(!App::make("3enib_authz")->isAdmin())
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire cela"]);
		}

		$user_id = Input::get("user_id", 0);

		if($user_id != 0)
		{
			$user = User::find($user_id);
			$user->admin = 0;
			$user->save();

		return Redirect::to("student/list")
			->with("notifications_infos", ["L'étudiant <b>".$user->firstname." ".$user->lastname."</b> n'est est plus administrateur"]);
		}
			return Redirect::to("/")
				->with("notifications_errors", ["L'utilisateur n'existe pas"]);
	}


	public function getReset($email="", $hash="")
	{

		if($hash == "")
		{
			$user = User::where("email", "=", $email)->get();

			if(count($user)==0)
			{
				return Redirect::to("user/signin")
					->with("notifications_errors", ["Ce compte n'existe pas"]);
			}

			$user = $user[0];		

			$data = [
					"token"=>$user->remember_token,
					"email"=>$email
					];


			Mail::send("emails.account.reset", $data, function($message) use($email){
					$message->from("subscription@3enib.fr");
					$message->to($email)->subject("Remise à zéro mot de passe 3ENIB");
				});
			
			return Redirect::to("user/signin")
				->with("notifications_success", ["Un email vous a été envoyé"]);
		}
		else
		{
			$email = preg_replace("/%40/", "@", $email);

			$users = User::where("remember_token", "=", $hash)->where("email", "=", $email)->get();


			if(count($users)==1)
			{
				$user = $users[0];

				Session::set("headerTitle", "Changer de mot de passe");
				return View::make("user.reset", compact("user"));
			}
			else
			{
			return Redirect::to("user/signin")
				->with("notifications_errors", ["Une erreur est survenue"]);
			}
		}
	}

	public function postReset()
	{
		$rules = array(
				"password"=>"required|min:5|confirmed",
				"password_confirmation"=>"required"
			);

		$validation = Validator::make(Input::all(), $rules);

		$hash  = Input::get("hash");
		$email = Input::get("email"); 
		$user = User::where("remember_token", "=", $hash)->where("email", "=", $email)->get()[0];

		if($validation->fails()){

			Session::set("headerTitle", "Changer de mot de passe");
			return View::make("user.reset", compact("user"))
			->withErrors($validation);
		}

		$user->password= Hash::make(Input::get("password"));
		$user->save();

		return Redirect::to("user/signin")
			->with("notifications_success", ["Votre mot de passe a été modifié"]);
	}

}
