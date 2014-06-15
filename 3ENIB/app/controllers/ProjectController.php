<?php

class ProjectController extends BaseController {

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
	public function create()
	{
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
			echo "test";
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
