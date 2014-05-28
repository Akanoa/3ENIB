<?php

class Project extends Eloquent {
	
    public function students(){
        return $this->has_many('student');
    }

    public function companies(){
        return $this->belongs_to('company');
    }
}