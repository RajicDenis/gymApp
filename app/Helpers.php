<?php

namespace App;

use Carbon\Carbon;

class Helpers {

	/**
	 * Check if current day of the week is Sunday
	 * If yes, return true
	 */
	public static function isSunday() {

		$currentDay = Carbon::parse(Time::find(1)->time)->dayOfWeek;

		if($currentDay == 0) {
			return true;
		}

		return false;
	}
}