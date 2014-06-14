<?php

class Project extends Eloquent {

	protected $table = "projects";
	
    public function students(){
        return $this->hasMany('student');
    }

    public function company(){
        return $this->belongsTo('company');
    }
}