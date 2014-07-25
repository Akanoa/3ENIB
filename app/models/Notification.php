<?php

class Notification extends \Eloquent {

	protected $table = "notifications";
	protected $fillable = ["recipient_id", "text", "link_to"];

}