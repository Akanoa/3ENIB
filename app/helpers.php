<?php


//--------------------------------
//           Helpers
//--------------------------------

class _3ENIB_Project
{

	public function __construct (){

	}

	public function convertStringProjectState($state){
		$conversionTable = [
			0 => "Non validé",
			1 => "En cours de recrutement",
			2 => "En cours de réalisation",
			3 => "Archivé",
			4 => "Abandonné"
		];

		return $conversionTable[$state];
	}

	public function studentHadSubscribedToProject($project, $student=null)
	{
		if(!Auth::check())
			return false;
		if($student != null)
		{
			if(sizeof($project->students()->where("student_id", "=", $student->id)->get()) != 0)
				return true;
		}
		if(sizeof($project->students()->where("student_id", "=", Auth::user()->own->id)->get()) != 0)
			return true;
		return false;
	}

	public function studentHasBeenExcludeFromProject($project)
	{
		if(!Auth::check())
			return false;

		if(sizeof($project->students()->where("student_id", "=", Auth::user()->own->id)->where("student_state", "=", 2)->get()) != 0)
			return true;
		return false;
	}

	public function studentHasBeenAcceptedOnProject($project)
	{
		if(!Auth::check())
			return false;

		if(sizeof($project->students()->where("student_id", "=", Auth::user()->own->id)->where("student_state", "=", 1)->get()) != 0)
			return true;
		return false;
	}

	public function isVisible($project)
	{
		$visible = false;
		//if user is an admin
		if(Auth::check()){
			if(Auth::user()->admin == 1)
				return true;
		}
		//if project isn't validated
		if($project->state == 0)
		{
			if(Auth::check())
			{
				if(Auth::user()->id == $project->company->user->id)
					$visible = true;
			}
		}

		else if($project->state == 1)
			$visible = true;

		else if(Auth::check() and $project->state == 2)
		{	
			if(App::make("3enib_authz")->isStudent())
				$visible = sizeof($project->students()->where("student_id", "=", Auth::user()->own->id)->where("student_state", "=", 1)->get()) !=0;

			if ((App::make("3enib_authz")->isCompany() and $project->company->id == Auth::user()->own->id))
				$visible = true;
		}

		else if($project->state == 3)
			$visible = true;

		return $visible;
	}

	public function documentIsVisible($document, $project)
	{
		if($document->visibility==0 and Auth::check())
		{
			$owner = $project->company->user;
			//if logged user isn't an admin or the document's owner 
			if(Auth::user()->id!=$owner->id and Auth::user()->admin!=1)
			{
				if(!$this->studentHasBeenAcceptedOnProject($project))
					return false;
			}
		}
		return true;
	}
}

class _3ENIB_Authz{

	public function __construct (){

	}

	public function studentAllowedToSubscribeToProject($project)
	{
		if(!Auth::check())
			return false;
		if(Auth::user()->own_type != "student")
			return false;
		if($project->state != 1)
			return false;
		if(sizeof($project->students()->where("student_id", "=", Auth::user()->own->id)->get()) != 0)
			return false;
		return true;
	}

	public function isAdmin()
	{
		if(Auth::check() and Auth::user()->admin == 1)
			return true;
		return false;
	}

	public function isStudent()
	{
		if(Auth::check() and Auth::user()->own_type == "student")
			return true;
		return false;
	}

	public function isCompany()
	{
		if(Auth::check() and Auth::user()->own_type == "company")
			return true;
		return false;
	}


}

class _3ENIB_User
{
	public function __construct()
	{
		
	}

	public function formatedUserName()
	{
		if(Auth::guest())
			return "Utilisateur non connecté";
		$user = Auth::user();
		if($user->own_type == "student")
		{
			return $user->own->firstname." ".$user->own->lastname;
		}
		else if($user->own_type == "company")
		{
			return $user->own->name;
		}
	}

	public function userIsActive($user)
	{
		if($user->user->active)
			return true;
		return false;
	}

	public function userStatus($user)
	{
		if($user->user->active)
			return "Actif";
		return "Bloqué";
	}
}

class _3ENIB_Text
{
	public function __construct()
	{
		
	}

	public function filterText($text)
	{
		return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $text);
	}
}

class _3ENIB_Notification{

	public function __construct (){

	}

	public function studentAppliesToProject($student, $project)
	{
		$recipients = User::where("admin", "=", 1)->select("id")->get();


		foreach ($recipients as $recipient) 
		{

			$data =[
				"recipient_id"=>$recipient->id,
				"text"=>"L'étudiant $student->firstname $student->lastname a postulé sur le projet $project->name",
				"link_to"=>URL::to('project/show')."/".$project->id
			];

			Notification::create($data);
		}

	}

	public function companyCreatesAProject($project)
	{

		$recipients = User::where("admin", "=", 1)->select("id")->get();

		foreach ($recipients as $recipient) 
		{
			$data =[
				"recipient_id"=>$recipient->id,
				"text"=>"L'entreprise ".$project->company->name." a créé le projet $project->name",
				"link_to"=>URL::to('project/list')
			];

			Notification::create($data);
		}
	}

	public function adminAcceptsStudentApplication($project, $recipient_id)
	{
		$data =[
			"recipient_id"=>$recipient_id,
			"text"=>"Votre candidature a été accepté sur le projet $project->name",
			"link_to"=>URL::to('#')
		];

		Notification::create($data);
	}

	public function adminAcceptsCompanyProject($project)
	{
		$data =[
			"recipient_id"=>$project->company->user->id,
			"text"=>"Le projet $project->name a été accepté",
			"link_to"=>URL::to('#')
		];

		Notification::create($data);
	}

	public function launchProject($project)
	{
		//notification to company owner
		$data =[
			"recipient_id"=>$project->company->user->id,
			"text"=>"Le projet $project->name a été lancé",
			"link_to"=>URL::to('project/show')."/".$project->id
		];

		Notification::create($data);

		foreach($project->students()->where("student_state", "=", 1)->get() as $student)
		{
			$data =[
				"recipient_id"=>$student->user->id,
				"text"=>"Le projet $project->name a été lancé",
				"link_to"=>URL::to('project/show')."/".$project->id
			];
			Notification::create($data);
		}
	}

	public function finishProject($project)
	{
		//notification to company owner
		$data =[
			"recipient_id"=>$project->company->user->id,
			"text"=>"Le projet $project->name a été lancé",
			"link_to"=>URL::to('project/show')."/".$project->id
		];

		Notification::create($data);

		foreach($project->students()->where("student_state", "=", 1)->get() as $student)
		{
			$data =[
				"recipient_id"=>$student->user->id,
				"text"=>"Le projet $project->name est terminé",
				"link_to"=>URL::to('project/show')."/".$project->id
			];
			Notification::create($data);
		}
	}

	public function getNotification()
	{
		$notifications = [];
		if(Auth::check())
		{
			$notifications = Notification::where("recipient_id", "=", Auth::user()->id)->get();
		}

		return [count($notifications), $notifications];
	}
}

//--------------------------------
//           Bind
//--------------------------------

App::bind("3enib_project", function($app){
	return new _3ENIB_Project;
});

App::bind("3enib_authz", function($app){
	return new _3ENIB_Authz;
});

App::bind("3enib_text", function($app){
	return new _3ENIB_Text;
});

App::bind("3enib_user", function($app){
	return new _3ENIB_User;
});

App::bind("3enib_notification", function($app){
	return new _3ENIB_Notification;
});