<?php

class Student extends \Eloquent {

	public function users(){
		return $this->morphMany('User', 'own');
	}

    public function user()
    {
        return $this->belongsTo('User');
    }
}