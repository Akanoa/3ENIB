<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

class DocumentController extends BaseController
{

	public function __construct()
	{
		$this->beforeFilter('auth', ["only"=>"avatar"]);
		$this->beforeFilter('csrf', array('on' => 'post'));
	}


	public function getAvatar($name)
	{
		if(Auth::check())
		{
			$path = storage_path()."/uploads/".Auth::user()->id."/avatar/".$name;
			$contents = file_get_contents($path);
			$statusCode = "200 OK";
			$response = Response::make($contents, $statusCode);
			$response->header('Content-Type', 'image/jpeg');
			return $response;
		}
		else
		{
			throw new HttpExecption("403 Forbidden", 403);
			
		}
	}

	public function getLogo($id, $name)
	{

		$path = storage_path()."/uploads/".$id."/logo/".$name;
		$contents = file_get_contents($path);
		$statusCode = "200 OK";
		$response = Response::make($contents, $statusCode);
		$response->header('Content-Type', 'image/jpeg');
		return $response;

	}
}