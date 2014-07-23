<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

class DocumentController extends BaseController
{

	public function __construct()
	{
		$this->beforeFilter('auth', ["only"=>"avatar"]);
		$this->beforeFilter('csrf', array('on' => 'post'));
	}


	public function getAvatar($id, $name="")
	{

		$path = storage_path()."/uploads/".$id."/avatar/".$name;
		if (!file_exists($path))
			$path=storage_path()."/uploads/0/avatar/placeholder";
		$contents = file_get_contents($path);
		$statusCode = "200 OK";
		$response = Response::make($contents, $statusCode);
		$response->header('Content-Type', 'image/jpeg');
		return $response;
		
	}

	public function getLogo($id, $name="")
	{

		$path = storage_path()."/uploads/".$id."/logo/".$name;
		if (!file_exists($path))
			$path=storage_path()."/uploads/0/avatar/placeholder";
		$contents = file_get_contents($path);
		$statusCode = "200 OK";
		$response = Response::make($contents, $statusCode);
		$response->header('Content-Type', 'image/jpeg');
		return $response;

	}

	public function getPdf($id, $type, $name="")
	{
		if($type=="cv")
		{
			if(!App::make("3enib_authz")->isAdmin())
			{
				return Redirect::to('/')->with('notifications_errors', ["Vous n'êtes pas autorisé à accéder à cette ressource!"]);
			}
		}

		$path = storage_path()."/uploads/".$id."/pdf/".$name;
		if(file_exists($path))
		{
			$contents = file_get_contents($path);
			$statusCode = "200 OK";
			$response = Response::make($contents, $statusCode);
			$response->header('Content-Type', 'application/pdf');
			return $response;
		}
		else
		{
			return Redirect::to('/')->with('notifications_errors', ["Ce fichier n'existe pas!"]);
		}

	}
}