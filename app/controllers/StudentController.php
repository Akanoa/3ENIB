<?php

class StudentController extends \BaseController {

	function getList($id){
		
	}

	function getShow($id){
		if(App::make("3enib_authz")->isAdmin())
		{		
			$student  = Student::find($id);
			$projects = PivotStudentProject::where("student_id", "=", $id)->get();
			return View::make("student.show", compact("student"));
		}
		else
		{
			return Redirect::to("/")
				->with("notifications_errors", ["Vous n'avez pas le droi d'accéder à cette page"]);
		}
	}
}