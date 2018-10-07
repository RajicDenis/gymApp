<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

	Route::get('/programs', 'ProgramController@index')->name('program');

	Route::get('/programs/create', 'ProgramController@create')->name('program_create');

	Route::post('/programs', 'ProgramController@store')->name('program_store');

	Route::get('/programs/{id}/pause', 'ProgramController@pause')->name('program_pause');

	Route::get('/programs/{id}/continue', 'ProgramController@continue')->name('program_continue');

	Route::get('/programs/{id}/cancel', 'ProgramController@cancel')->name('program_cancel');

	Route::get('/programs/{id}/change/{type}', 'ProgramController@change')->name('program_change');

	Route::post('/programs/{id}/changeLevel', 'ProgramController@changeLevel')->name('program_level');

	Route::post('/programs/{id}/changeTrainer', 'ProgramController@changeTrainer')->name('program_trainer');

	/* Time travel route -- for testing */
	Route::post('/timetravel', 'TimeController@travel')->name('travel');
});


