<?php

class StudentController extends \BaseController {

	function getList(){
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

	function getShow($id){
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
}