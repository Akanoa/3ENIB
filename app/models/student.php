<?php

class Student extends \Eloquent {

    protected $fillable = ["*"];

	public function users(){
		return $this->morphMany('User', 'own');
	}

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function projects()
    {
    	return $this->hasMany('project');
    }
}