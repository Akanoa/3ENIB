<?php

class ProjectController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth', ["except"=>["getShow"]]);
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

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
			return Redirect::to("project/edit/".$id)
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

			Project::create($datas);

			$infos = ["Votre projet a été soumis à la modération, il sera visible pour le reste des étudiants dès que le projet sera validé."];

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
		$posts = Post::where("project_id", "=", $id)->where("state", "=", 1)->get();
		$files = [];
		$auth = Auth::check();
		Session::set("headerTitle", "Entreprise | ".$project->company->name);
		return View::make("project.show", compact("project", "posts", "files", "auth"));
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


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
