<?php

class Post extends Eloquent {
	protected $fillable = array('message', 'project_id', 'user_id');
	protected $table = "posts";

	public function user()
	{
		return $this->belongsTo("user");
	}
}