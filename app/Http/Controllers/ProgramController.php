<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Program;
use App\Trainer;
use Session;
use Carbon\Carbon;

class ProgramController extends Controller
{
    /**
     * Show the My Programs view
     */
    public function index() {

    	$program = new Program;

        // Get all programs from logged in user
    	$data = $program->getPrograms(Auth::id());

    	return view('programs')->with('programs', $data);
    }

    /**
     * Show view with form to create new program
     */
    public function create() {

        // Get all trainers from the database to show in form
    	$trainer = new Trainer;
    	$trainers = $trainer->getAllTrainers();

    	return view('create')->with('trainers', $trainers);
    }

    /**
     * Save the program details to the DB
     * @param array $request data from post form
     */
    public function store(Request $request) {

        // Get day of the week from passed in start date
    	$startDayOfWeek = Carbon::parse($request->start_date)->dayOfWeek;

        // Check if the passed in start day is sunday
    	if($startDayOfWeek != 0 ) {

    		Session::flash('status', 'Program can only start on Sunday!!');
    		Session::flash('alert_type', 'alert-danger');

    		return redirect()->back();
    	}

    	$program = new Program;

    	$program->store($request);

    	Session::flash('status', 'Program saved!');
    	Session::flash('alert_type', 'alert-success');

    	return redirect()->route('program');
    }

    /**
     * Pause the program
     * @param int $id program id
     */
    public function pause($id) {

    	$program = new Program;

    	$program->pause($id);

    	Session::flash('status', 'Program paused!');
    	Session::flash('alert_type', 'alert-warning');

    	return redirect()->route('program');
    }

    /**
     * Continue the program
     * @param int $id program id
     */
    public function continue($id) {

    	$program = new Program;

    	$program->continue($id);

    	Session::flash('status', 'Program continued!');
    	Session::flash('alert_type', 'alert-success');

    	return redirect()->route('program');
    }

    /**
     * Cancel the program
     * @param int $id program id
     */
    public function cancel($id) {

    	$program = new Program;

    	$program->cancel($id);

    	Session::flash('status', 'Program canceled!');
    	Session::flash('alert_type', 'alert-danger');

    	return redirect()->route('program');

    }

    /**
     * Show the form to change level or trainer
     * @param int $id program id
     * @param int $type id of the trainer
     */
    public function change($id, $type) {

    	$program = Program::find($id);
    	$trainers = Trainer::all();

    	return view('change')
    		->with('program', $program)
    		->with('trainers', $trainers)
    		->with('type', $type);
    }

    /**
     * Change the level
     * @param array $request data from the post form
     * @param int $id program id
     */
    public function changeLevel(Request $request, $id) {

    	$program = new Program;

    	$program->changeLevel($id, $request->level);

    	Session::flash('status', 'Level changed!');
    	Session::flash('alert_type', 'alert-success');

    	return redirect()->route('program');
    }

    /**
     * Change the trainer
     * @param array $request data from the post form
     * @param int $id program id
     */
    public function changeTrainer(Request $request, $id) {

    	$program = new Program;

    	$program->changeTrainer($id, $request->trainer);

    	Session::flash('status', 'Trainer changed!');
    	Session::flash('alert_type', 'alert-success');

    	return redirect()->route('program');
    }
}
