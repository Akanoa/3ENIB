<?php

class Document extends \Eloquent {

	protected $table = "documents";
	protected $fillable = ["project_id", "name", "path", "visibility"];

}