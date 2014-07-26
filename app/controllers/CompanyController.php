<?php

class CompanyController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$companies = Company::all();
		Session::set('headerTitle', "Entreprises");
		return View::make("company.list")
			->with('companies', $companies);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	public function show($id)
	{
		$company = Company::find($id);
		$projects = $company->projects;
		$headerTitle = "Entreprises | ".$company->name;

		$authorized = False;
		if(Auth::check())
		{
			if($company->user->id == Auth::user()->id or Auth::user()->admin == 1)
				$authorized = True;
		}

		Session::set('headerTitle', $headerTitle);
		return View::make("company.show", compact("company", "projects", "authorized"));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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

	public function getDelete($id)
	{
		$company = Company::findOrFail($id);
		$user = $company->user;
		$name = $company->name;

		if(Auth::user()->admin == 0 )
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire ça"]);
		}
		//delete all related projects
		foreach ($company->projects() as $project) {
			//delete posts 's project
			Post::where("project_id", "=", $project->id)->delete();
			//delete relation between student and project
			PivotStudentProject::where("project_id", "=", $project->id)->delete();

			//delete related files
			foreach (Document::where("project_id", "=", $project->id) as $document) {
				unset(storage_path()."/uploads/".$user->id."/pdf/".$document->path);
			}
		}
		$company->projects()->delete();
		$user->delete();
		unset(storage_path()."/uploads/".$user->id."/avatar/".$company->avatar_filepath);
		unset(storage_path()."/uploads/".$user->id."/logo/".$company->photo_filepath);
		$company->delete();


		return Redirect::to("student/list")
			->with("notifications_success", ["L'étudiant <b>$name</b> a été supprimé"]);

	}


}
