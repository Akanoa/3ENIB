<?php

class Project extends Eloquent {

	protected $table = "projects";
	protected $fillable = ["name","description","required_skills","estimated_time","remuneration","state","company_id"];

    public function students(){
        return $this->hasMany('student');
    }

    public function company(){
        return $this->belongsTo('company');
    }
}