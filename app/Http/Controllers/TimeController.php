<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use Session;

class TimeController extends Controller
{
    
    /**
     * Store the current date to the database
     * @param array $request data from the post form
     */
    public function travel(Request $request) {
        
        $time = new Time;

        $time->store($request->date);

        Session::flash('status', 'Timetravel successful!');
        Session::flash('alert_type', 'alert-success');

        return redirect()->route('program');

    }
}
