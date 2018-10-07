<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Trainer;
use App\Time; /* Only for testing */
use Carbon\Carbon;
use App\Listener as Listener;

class Program extends Model
{
	// Default program duration
	public $duration = 52;

	public function users() {

		return $this->belongsTo('App\User');
	}

	public function trainers() {

		return $this->belongsToMany('App\Trainer');
	}

    public function getPrograms($userId) {

    	$data = $this->where('user_id', $userId)->get();

    	return $data;
    }

    /**
     * Save program to database, as well as the relationships
     * @param array $request program data sent from post form
     */
    public function store($request) {

    	$this->name = $request->name;
    	$this->level = $request->level;
    	$this->start_date = $request->start_date;
    	$this->duration = $this->duration;
    	$this->end_date = Carbon::parse($request->start_date)->addWeeks($this->duration);
    	$this->new_end_date = Carbon::parse($request->start_date)->addWeeks($this->duration);
    	$this->user_id = Auth::id();
    	$this->save();

        $trainers = Trainer::find($request->trainer);
        $trainers->programs()->attach($this->id);

    	$user = User::find(Auth::id());

    	$user->trainers()->attach($request->trainer);
    }

    /**
     * Pause the program and set the paused date
     * @param int $programId
     */
    public function pause($programId) {

    	$program = $this->find($programId);

    	$program->paused = true;
    	$program->paused_date = Time::find(1)->time; // For testing
    	// $program->paused_date = Carbon::now()->format('Y-m-d');   --> for real app
    	$program->continue_date = null;
    	$program->save();
    }

    /**
     * Continue the program and set the continued date
     * @param int $programId
     */
    public function continue($programId) {

    	$program = $this->find($programId);

    	$program->paused = false;
    	$program->continue_date = Time::find(1)->time;
    	// $program->continue_date = Carbon::now()->format('Y-m-d');   --> for real app
    	$program->save();

    	// Add to the end date based on the length of the pause
    	Listener::changeDate($programId);
    }

    /**
     * Cancel the program 
     * @param int $programId
     */
    public function cancel($programId) {

    	$program = $this->find($programId);

    	$program->canceled = true;
    	$program->paused = false;
    	$program->save();
    }

   	/**
     * Change the level of the program 
     * @param int $programId
     * @param string $level level name
     */ 
    public function changeLevel($programId, $level) {

    	$program = $this->find($programId);

    	$program->level = $level;
    	$program->save();

    }

    /**
     * Change the trainer of the program 
     * @param int $programId
     * @param string $trainer trainer name 
     */ 
    public function changeTrainer($programId, $trainer) {

    	$user = User::find(Auth::id());
    	$program = Program::find($programId);

    	$user->trainers()->attach($trainer);
    	$program->trainers()->attach($trainer);

    }
}
