<?php

class Project extends Eloquent {

	protected $table = "projects";
	protected $fillable = ["name","description","required_skills","estimated_time","remuneration","state","company_id"];

    public function students(){
        return $this->belongsToMany('Student', 'project_student_pivot', 'project_id', 'student_id');
    }

    public function company(){
        return $this->belongsTo('company');
    }

}