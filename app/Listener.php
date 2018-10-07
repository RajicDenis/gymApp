<?php

namespace App;

use Carbon\Carbon;
use App\Program;
use App\Time; // For testing

class Listener {

	public $percent = 0;

	/**
	 * Add paused time to the end of the program
	 * @param int $programId
	 */
	public static function changeDate($programId) {

		$program = Program::find($programId);

		if($program->continue_date == null) {
			// $now = Carbon::now();  --> for real app
			$now = Carbon::parse(Time::find(1)->time);  // for testing
		} else {
			$now = Carbon::parse($program->continue_date);
		}

		$pausedDate = Carbon::parse($program->paused_date);
		// Get difference in weeks from paused date to now
		$dateDiff = $now->diffInWeeks($program->paused_date);

		// Add the paused time to the program end date
		$newDate = Carbon::parse($program->end_date)->addWeeks($dateDiff);
		$newDate = $newDate->format('Y-m-d');

		// Update the end date in the database
		$program->new_end_date = $newDate;
		$program->save();
		

	}

	/**
	 * Calculate program completed percentage for the progress bar
	 * @param int $programId
	 */
	public static function getPercentage($programId) {

		$program = Program::find($programId);

		if($program->continue_date == null) {
			// $now = Carbon::now();  --> for real app
			$now = Carbon::parse(Time::find(1)->time);  // for testing
		} else {
			if(Carbon::parse(Time::find(1)->time) <= Carbon::parse($program->continue_date)) {
				$now = Carbon::parse($program->continue_date);
			} else {
				// $now = Carbon::now();  --> for real app
				$now = Carbon::parse(Time::find(1)->time);  // for testing
			}	
		}

		$endDate = Carbon::parse($program->new_end_date);
		// Get number of weeks that are left to the end of the program
		$weeksLeft = $endDate->diffInWeeks($now);

		// Get the current week
		$currentWeek = $program->duration - $weeksLeft;

		// Calculate percentage based on current week and total duration (52 weeks)
		$percent = ($currentWeek / $program->duration) * 100;

		if($percent > 100.00) {
			$percent = 100.00;
		}

		if($percent < 0) {
			$percent = 0;
		}

		// If the program entered the last week, show 99% until the last day (instead of 100% for the last 7 days)
		if($percent == 100 && $now != $endDate) {
			$percent = 99.00;
		}
		
		// Round up to two decimals
		return round($percent, 2);

	}

	/**
	 * Check if program is finished, if yes ->return true
	 * @param int $programId
	 */
	public static function isFinished($programId) {

		$program = Program::find($programId);

		if(Carbon::parse(Time::find(1)->time) >= $program->new_end_date) {
			$program->finished = true;
			$program->paused = false;
			$program->canceled = false;
			$program->save();
		}

	}

}