<?php

class User extends Eloquent {
	public function own(){
		return $this->morpTo();
	}
}