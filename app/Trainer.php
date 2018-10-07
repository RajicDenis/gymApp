<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    public function programs() {

		return $this->belongsToMany('App\Program');
	}

	public function users() {

		return $this->belongsToMany('App\User');
	}

	public function getAllTrainers() {

		$data = $this->all();

		return $data;
	}
}
