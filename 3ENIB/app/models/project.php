<?php

class Project extends Eloquent {

	protected $table = "projects";
	
    public function students(){
        return $this->has_many('student');
    }

    public function companys(){
        return $this->belongs_to('company');
    }
}