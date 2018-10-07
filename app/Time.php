<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
	// Set the database table name
    protected $table = 'timelapse';

    /**
     * Set the current time
     * @param date $date date to be set as current
     */
    public function store($date) {

    	// Empty the database before adding new date
    	$this->truncate();

    	$this->time = $date;
    	$this->save();
    }
}
