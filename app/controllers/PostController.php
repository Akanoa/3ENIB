<?php

class PostController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
	
	public function postCreate()
	{
		$datas = [
			"message" => Input::get("message"),
			"project_id" => Input::get("project_id", 0),
			'user_id'=>Auth::user()->id
		];

		Post::create($datas);

		return Redirect::to(Input::get("redirection", "/"));
	}

	public function postEdit($id)
	{

		$post = Post::find($id);
		if(Auth::user()->admin == 0 and Auth::user()->id != $post->user->id)
		{
			Session::set("headerTitle", "Entreprise | ".Project::find($post->project_id)->company->name);
			$infos = ["Vous n'êtes pas autorisé à modifier ce message"];
			return Redirect::to('project/show/'.$post->project_id)
				->with("notifications_errors", $infos);
		}
		else
		{
			$post->message = Input::get("message");
			$post->save();
			Session::set("headerTitle", "Entreprise | ".Project::find($post->project_id)->company->name);
			$infos = ["Message modifié"];
			return Redirect::to('project/show/'.$post->project_id)
				->with("notifications_success", $infos);
		}

	}

	public function getDelete($id)
	{
		$post = Post::find($id);
		if(Auth::user()->admin == 0 and Auth::user()->id != $post->user->id)
		{
			Session::set("headerTitle", "Entreprise | ".Project::find($post->project_id)->company->name);
			$infos = ["Vous n'êtes pas autorisé à supprimer ce message"];
			return Redirect::to('project/show/'.$post->project_id)
				->with("notifications_errors", $infos);
		}
		else
		{
			$post->state = 0;
			$post->save();
			Session::set("headerTitle", "Entreprise | ".Project::find($post->project_id)->company->name);
			$infos = ["Message supprimé"];
			return Redirect::to('project/show/'.$post->project_id)
				->with("notifications_success", $infos);
		}
	}
}