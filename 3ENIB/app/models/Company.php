<?php

class Company extends Eloquent {
	protected $table = "companies";

	public function users(){
		return $this->morphMany('User', 'own');
	}
}