<?php

class PostController extends \BaseController {
	
	public function postCreate(){
		$datas = [
			"message" => Input::get("message"),
			"project_id" => Input::get("project_id", 0),
			'user_id'=>Auth::user()->id
		];

		Post::create($datas);

		return Redirect::to(Input::get("redirection", "/"));
	}
}