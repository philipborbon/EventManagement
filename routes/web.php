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
    if (Auth::check()) {
        return redirect()->action('HomeController@index');
    } else {
        return view('welcome');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'EventManagement\Http\Middleware\AdminMiddleware'], function(){
	Route::resource('users','UserController');
	Route::resource('events','EventController');
	Route::resource('salarygrades','SalaryGradeController');
	Route::resource('deductiontypes','DeductionTypeController');

	Route::resource('rentalspaces','RentalSpaceController');
	Route::get('rentalspaces/{id}/spacemap','RentalSpaceController@spaceMap');
	Route::patch('rentalspaces/{id}/spacemap','RentalSpaceController@updateMap');

	Route::resource('rentalareatypes','RentalAreaTypeController');

	Route::resource('activities','ActivityController');
	Route::get('activities/{id}/participants','ActivityController@participants');
	Route::get('activities/{id}/participants/create','ActivityController@createParticipant');
	Route::post('activities/{id}/participants','ActivityController@storeParticipant');
	Route::get('activities/{id}/participants/{participantId}/edit','ActivityController@editParticipant');
	Route::patch('activities/{id}/participants/{participantId}','ActivityController@updateParticipant');
	Route::delete('activities/{id}/participants/{participantId}','ActivityController@destroyParticipant');

	Route::get('activities/{id}/participants/create','ActivityController@createParticipant');

	Route::resource('documenttypes','DocumentTypeController');
	Route::resource('announcements','AnnouncementController');
	Route::resource('mayorschedules','MayorScheduleController');
});