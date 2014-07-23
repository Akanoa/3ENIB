<?php

class Company extends Eloquent {
	protected $table = "companies";

	public function users(){
		return $this->morphMany('User', 'own');
	}

    public function user()
    {
        return $this->belongsTo('User');
    }

	public function projects()
	{
		return $this->hasMany("Project");
	}
}