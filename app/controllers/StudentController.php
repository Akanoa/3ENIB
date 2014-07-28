<?php

class StudentController extends \BaseController {

	public function getList(){
		if(App::make("3enib_authz")->isAdmin())
		{		
			$students  = Student::orderBy("firstname")->get();
			return View::make("student.list", compact("students"));
		}
		else
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'avez pas le droit d'accéder à cette page"]);
		}
	
	}

	public function getShow($id){
		if(App::make("3enib_authz")->isAdmin())
		{		
			$student  = Student::find($id);
			$projects = PivotStudentProject::leftJoin("projects", "projects.id", "=", "project_student_pivot.project_id")->where("student_id", "=", $id)->get();
			return View::make("student.show", compact("student", "projects"));
		}
		else
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'avez pas le droit d'accéder à cette page"]);
		}
	}

	public function getDelete($id)
	{
		$student = Student::findOrFail($id);
		$user = $student->user;
		$name = $student->firstname. " ".$student->lastname;

		if(Auth::user()->admin == 0 )
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'êtes pas autorisé à faire ça"]);
		}
		
		PivotStudentProject::where("student_id", "=", $id)->delete();
		Post::where("user_id", "=", $user->id)->delete();
		$user->delete();
		unlink(storage_path()."/uploads/".$user->id."/avatar/".$student->avatar_filepath);
		unlink(storage_path()."/uploads/".$user->id."/logo/".$student->photo_filepath);
		unlink(storage_path()."/uploads/".$user->id."/pdf/".$student->cv_filepath);
		$student->delete();


		return Redirect::to("student/list")
			->with("notifications_success", ["L'étudiant <b>$name</b> a été supprimé"]);

	}
}