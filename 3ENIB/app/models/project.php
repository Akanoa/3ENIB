<?php

class Project extends Eloquent {

	protected $table = "projects";
	
    public function students(){
        return $this->hasMany('student');
    }

    public function companys(){
        return $this->belongsTo('company');
    }
}