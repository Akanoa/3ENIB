<?php 


class PivotStudentProject extends Eloquent
{
	protected $table = "project_student_pivot";
	protected $fillable = ["project_id", "student_id"];
}


 ?>