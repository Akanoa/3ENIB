<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

class DocumentController extends BaseController
{

	public function __construct()
	{
		$this->beforeFilter('auth', ["only"=>"avatar"]);
		$this->beforeFilter('csrf', array('on' => 'post'));
	}


	public function getAvatar($id, $name)
	{

		$path = storage_path()."/uploads/".$id."/avatar/".$name;
		$contents = file_get_contents($path);
		$statusCode = "200 OK";
		$response = Response::make($contents, $statusCode);
		$response->header('Content-Type', 'image/jpeg');
		return $response;
		
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

	public function getPdf($id, $name)
	{
		if(Auth::check() and Auth::user()->own_type == "student")
		{
			$path = storage_path()."/uploads/".$id."/pdf/".$name;
			$contents = file_get_contents($path);
			$statusCode = "200 OK";
			$response = Response::make($contents, $statusCode);
			$response->header('Content-Type', 'application/pdf');
			return $response;
		}

	}
}