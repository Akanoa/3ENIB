<?php

class ProjectController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth', ["except"=>["getShow", "getList"]]);
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getList()
	{
		$projects = Project::orderBy("company_id", "ASC")->orderBy("state")->get();
		Session::set("headerTitle", "Liste des projets");
		return View::make("project.list", compact("projects"));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate($company_id)
	{
		$company = Company::find($company_id);
		$user = Auth::user();
		if($user->own_type == "student" and $user->admin == 0)
		{
			Session::set("headerTitle", "Entreprise | ".$company->name);
			$infos = ["Vous n'êtes pas autorisé à créer un projet"];
			return Redirect::to('company/'.$company_id)
				->with("notifications_errors", $infos);
		}
		else
		{


			Session::set("headerTitle", "Entreprise | ".$company->name);
			return View::make("project.create")
				->with("company_id", $company_id);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$rules = array(
				"name"=>"required|max:255",
				"remuneration"=>"required|numeric",
				"estimated_time"=>"max:255",
				"skills"=>"max:255",
			);

		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
		{
			Session::set("headerTitle", "Edition");
			return Redirect::to("project/create/".Input::get("company_id"))
				->withErrors($validation)
				->withInput();
		}
		else
		{
			$company_id = Input::get("company_id");
			$datas=[
				"name"=>Input::get("name"),
				"description"=>Input::get("description"),
				"required_skills"=>Input::get("skills"),
				"estimated_time"=>Input::get("estimated_time"),
				"remuneration"=>Input::get("remuneration"),
				"state"=>0,
				"company_id"=>$company_id
			];


			$project_id = DB::table('projects')->insertGetId($datas);

			$infos = ["Votre projet a été soumis à la modération, il sera visible pour le reste des étudiants dès que le projet sera validé."];

			App::make("3enib_notification")->companyCreatesAProject(Project::find($project_id), 1);

			Session::set("headerTitle", "Edition");
			return Redirect::to("company/".$company_id)
				->with("notifications_infos", $infos);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		$project = Project::find($id);

		if(!App::make("3enib_project")->isVisible($project))
		{
			Session::set("headerTitle", "Entreprise | ".$project->company->name);
			return Redirect::to("company/".$project->company->id)
				->with("notifications_errors", ["Vous n'avez pas le droit de visionner ce projet"]);
		}

		$students = [];

		foreach($project->students()->get() as $student)
		{	
			
			array_push($students, [$student, PivotStudentProject::where("student_id", "=", $student->id)->where("project_id", "=", $project->id)->get()[0]->student_state]);

		}


		$posts = Post::where("project_id", "=", $id)->where("state", "=", 1)->get();
		$files = Document::where("project_id", "=", $id)->get();
		$auth = Auth::check();
		$allow_to_remove_docs = Auth::check()?Auth::user()->id==$project->company->user->id or Auth::user()->admin==1:false;
		Session::set("headerTitle", "Entreprise | ".$project->company->name);
		return View::make("project.show", compact("project", "posts", "files", "auth", "students", "allow_to_remove_docs"));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$project = Project::find($id);
		$user = Auth::user();

		if(($user->own_type == "company" and $project->company->id != $user->own->id) or ($user->own_type == "student" and $user->admin == 0))
		{
			Session::set("headerTitle", "Entreprise | ".$project->company->name);
			$infos = ["Vous n'êtes pas autorisé à modifier ce projet"];
			return Redirect::to('company/'.$project->company->id)
				->with("notifications_errors", $infos);
		}
		else
		{
			$datas = [
				"id"=>$project->id,
				"name"=>$project->name,
				"description"=>$project->description,
				"remuneration"=>$project->remuneration,
				"skills"=>$project->required_skills,
				"estimated_time"=>$project->estimated_time
			];

			Session::set("headerTitle", "Entreprise | ".$project->company->name);
			return View::make("project.edit", compact("datas"));
		}
	}

	public function postEdit($id)
	{
		$rules = array(
				"name"=>"required|max:255",
				"remuneration"=>"required|numeric",
				"estimated_time"=>"max:255",
				"skills"=>"max:255",
			);

		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
		{
			Session::set("headerTitle", "Edition");
			return Redirect::to("project/edit/".$id)
				->withErrors($validation)
				->withInput();
		}
		else
		{
			$datas=[
				"name"=>Input::get("name"),
				"description"=>Input::get("description"),
				"skills"=>Input::get("skills"),
				"estimated_time"=>Input::get("estimated_time"),
				"remuneration"=>Input::get("remuneration")
			];

			$project = Project::find($id);

			$project->update($datas);

			$infos = ["Le projet a été édité."];

			Session::set("headerTitle", "Edition");
			return Redirect::to("company/".$project->company_id)
				->with("notifications_infos", $infos);
		}
	}

	public function postSignup()
	{
		$project_id = Input::get("project_id");
		$student_id = Input::get("student_id");

		$datas =[
			"project_id" =>$project_id,
			"student_id" =>$student_id
		];

		$project = Project::find($project_id);

		$project->students()->attach($student_id);

		App::make("3enib_notification")->studentAppliesToProject(Student::find($student_id), $project);

		Session::set("headerTitle", "Projet | ".Project::find($project_id)->name);
		return Redirect::to("project/show/".$project_id);
	}

	public function postSignout()
	{
		$project_id = Input::get("project_id");
		$student_id = Input::get("student_id");

		$datas =[
			"project_id" =>$project_id,
			"student_id" =>$student_id
		];

		$project = Project::find($project_id);

		$project->students()->detach($student_id);


		Session::set("headerTitle", "Projet | ".Project::find($project_id)->name);
		return Redirect::to("project/show/".$project_id);
	}

	public function postValidate()
	{
		$project_id = Input::get("project_id");

		if(!App::make("3enib_authz")->isAdmin())
		{
			Session::set("headerTitle", "Projet | Liste des projets");
			return Redirect::to("project/list")
				->with("notifications_errors", ["Vous êtes pas autorisé à faire ça"]);
		}

		$project = Project::find($project_id);
		$project->state = 1;
		$project->save();

		App::make("3enib_notification")->adminAcceptsCompanyProject($project);

		Session::set("headerTitle", "Projet | Liste des projets");
		return Redirect::to("project/list");
	}


	public function postActivate()
	{
		$project_id = Input::get("project_id");

		if(!App::make("3enib_authz")->isAdmin())
		{
			Session::set("headerTitle", "Projet | Liste des projets");
			return Redirect::to("project/list")
				->with("notifications_errors", ["Vous êtes pas autorisé à faire ça"]);
		}

		$project = Project::find($project_id);
		$project->state = 2;
		$project->save();

		App::make("3enib_notification")->launchProject($project);

		Session::set("headerTitle", "Projet | Liste des projets");
		return Redirect::to("project/list");
	}

	public function postArchive()
	{
		$project_id = Input::get("project_id");

		if(!App::make("3enib_authz")->isAdmin())
		{
			Session::set("headerTitle", "Projet | Liste des projets");
			return Redirect::to("project/list")
				->with("notifications_errors", ["Vous êtes pas autorisé à faire ça"]);
		}

		$project = Project::find($project_id);
		$project->state = 3;
		$project->save();

		App::make("3enib_notification")->finishProject($project);

		Session::set("headerTitle", "Projet | Liste des projets");
		return Redirect::to("project/list");
	}


	public function postClose()
	{
		$project_id = Input::get("project_id");

		if(!App::make("3enib_authz")->isAdmin())
		{
			Session::set("headerTitle", "Projet | Liste des projets");
			return Redirect::to("project/list")
				->with("notifications_errors", ["Vous êtes pas autorisé à faire ça"]);
		}

		$project = Project::find($project_id);
		$project->state = 4;
		$project->save();
		Session::set("headerTitle", "Projet | Liste des projets");
		return Redirect::to("project/list");
	}

	public function postExclude()
	{
		$project_id = Input::get("project_id");
		$student_id = Input::get("student_id");

		$project = Project::find($project_id);

		if(!App::make("3enib_authz")->isAdmin())
		{
			Session::set("headerTitle", "Projet | ".$project->name);
			return Redirect::to("project/show/".$project->id)
				->with("notifications_errors", ["Vous êtes pas autorisé à faire ça"]);
		}

		$student = Student::find($student_id);

		PivotStudentProject::where("project_id", "=", $project_id)->where("student_id", "=", $student_id)->update(["student_state"=> 0]);
		Session::set("headerTitle", "Projet | Liste des projets");
		return Redirect::to("project/show/".$project->id)
				->with("notifications_success", ["L'étudiant <b>".$student->firstname." ".$student->lastname." </b> est maintenant exclu du projet ".$project->name]);
	}

	public function postInclude()
	{
		$project_id = Input::get("project_id");
		$student_id = Input::get("student_id");

		$project = Project::find($project_id);

		if(!App::make("3enib_authz")->isAdmin())
		{
			Session::set("headerTitle", "Projet | ".$project->name);
			return Redirect::to("project/show/".$project->id)
				->with("notifications_errors", ["Vous êtes pas autorisé à faire ça"]);
		}

		$student = Student::find($student_id);

		PivotStudentProject::where("project_id", "=", $project_id)->where("student_id", "=", $student_id)->update(["student_state"=> 1]);


		App::make("3enib_notification")->adminAcceptsStudentApplication($project, $student->user->id);

		Session::set("headerTitle", "Projet | Liste des projets");
		return Redirect::to("project/show/".$project->id)
				->with("notifications_success", ["L'étudiant <b>".$student->firstname." ".$student->lastname." </b> est maintenant inclus dans le projet ".$project->name]);
	}

	public function getAddDocument($user_id, $project_id=0)
	{

		if((Auth::user()->id != $user_id and !App::make("3enib_authz")->isAdmin()) or $project_id==0)
		{
			if ($project_id == 0)
			{
				return  Redirect::to("/")
					->with("notifications_errors", ["Le projet n'existe pas"]);
			}
			else
			{
				return Redirect::to("project/show/$project_id")
					->with("notifications_errors", ["Vous n'êtes pas autorisé à faire ça"]);
			}

		}

		return View::make("project.adddocument", compact("user_id", "project_id"));
	}

	public function postAddDocument()
	{
		$user_id    = intval(Input::get("user_id")?:0);
		$project_id = intval(Input::get("project_id")?:0);
		$project    = Project::find($project_id);



		if((Auth::user()->id != $user_id and !App::make("3enib_authz")->isAdmin()) or $project_id==0)
		{
			if ($project_id == 0)
			{
				return  Redirect::to("/")
					->with("notifications_errors", ["Le projet n'existe pas"]);
			}
			else
			{

				return Redirect::to("project/show/$project_id")
					->with("notifications_errors", ["Vous n'êtes pas autorisé à faire ça"]);
			}

		}

		$documents = Input::file("document");
		$names     = Input::get("name");
		$privates  = Input::get("private");

		if($documents[0]!=NULL)
		{
			$i=0;
			$errors = [];
			$infos  = [];

			foreach ($documents as $document) 
			{
				
				if($document->getMimeType()!="application/pdf")
				{
					array_push($errors, "Le document <b>$names[$i]</b> doit-être au format pdf");
					$i++;
					continue;
				}

				$data = [
					"project_id"=>$project_id,
					"name"=>$names[$i],
					"path"=>md5(time().$document->getClientOriginalName()),
					"visibility"=>isset($privates[$i])?0:1
				];

				Document::create($data);

				$document->move(storage_path()."/uploads/".$user_id."/pdf/", $data["path"]);
				array_push($infos, "Le document <b>$names[$i]</b> a été ajouté au projet <b>$project->name</b>");
				$i++;
			}


			return Redirect::to("project/add-document/$user_id/$project_id")
				->with("notifications_success", $infos)
				->with("notifications_errors", $errors);
		}
		else
		{
			return Redirect::to("project/add-document/$user_id/$project_id")
				->with("notifications_infos", ["Aucun document n'a été ajouté"]);	
		}

	}

	public function getRemuneration($id)
	{
		$project = Project::findOrFail($id);
		$name = $project->name;
		$company_id = $project->company->id;
		if(Auth::user()->admin == 0 )
		{
			return Redirect::to("company/$company_id")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire ça"]);
		}

		$datas = ["remuneration" => Input::get("remuneration")];

		$project->update($datas);

		return Redirect::to("project/show/$id")
			->with("notifications_success", ["La rémunération du projet <b>$name</b> a été modifié"]);
		

	}

	public function getDelete($id, $redirect="list")
	{
		$project = Project::findOrFail($id);
		$name = $project->name;
		$company_id = $project->company->id;

		if(Auth::user()->admin == 0 and App::make("3enib_authz")->isCompany() and Auth::user()->own()->id =!$company_id)
		{
			return Redirect::to("company/$company_id")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire ça"]);
		}
		PivotStudentProject::where("project_id", "=", $id)->delete();
		$project->delete();

		if($redirect == "list")
		{
			return Redirect::to("project/list")
				->with("notifications_success", ["Le projet <b>$name</b> a été supprimé"]);
		}
		else if($redirect == "company")
		{
			return Redirect::to("company/$company_id")
				->with("notifications_success", ["Le projet <b>$name</b> a été supprimé"]);
		}

	}


}
