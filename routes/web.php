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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/welcome', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');


Route::resource('account','AccountController');
Route::resource('useridentifications', 'UserIdentificationController');
Route::post('useridentifications/upload', 'UserIdentificationController@upload');
Route::post('useridentifications/removeFile', 'UserIdentificationController@removeFile');


Route::get('rentaspace', 'ReservationController@spaces');
Route::get('rentaspace/create', 'ReservationController@create');
Route::post('rentaspace', 'ReservationController@store');
Route::get('rentaspace/reservations', 'ReservationController@reservations');
Route::get('rentaspace/reservations/{id}/proof', 'ReservationController@createProof');
Route::post('rentaspace/reservations/{id}/uploadProof', 'ReservationController@uploadProof');
Route::post('rentaspace/reservations/{id}/removeFile', 'ReservationController@removeFile');
Route::get('rentaspace/rented', 'PaymentController@rented');

Route::get('notifications/awarded/{id}', 'ReservationController@reservationApproved');

Route::group(['middleware' => 'EventManagement\Http\Middleware\ParticipantMiddleware'], function(){
	Route::get('events/register', 'ParticipantController@index');
	Route::post('activities/{id}/participants','ActivityController@storeParticipant');
});

Route::group(['middleware' => 'EventManagement\Http\Middleware\AdminMiddleware'], function(){
	Route::resource('users','UserController');
	Route::resource('salarygrades','SalaryGradeController');
	Route::resource('deductiontypes','DeductionTypeController');

	Route::patch('useridentifications/verify/{id}', 'UserIdentificationController@verify');

	Route::resource('attendances', 'AttendanceController');
	Route::resource('activedeductions', 'EmployeeActiveDeductionController');
	Route::resource('payslips', 'MonthlyPayoutController');
	Route::post('payslips/generate', 'MonthlyPayoutController@generate');
});

Route::group(['middleware' => 'EventManagement\Http\Middleware\EmployeeMiddleware'], function(){
	Route::resource('events','EventController');

	Route::resource('rentalspaces','RentalSpaceController');
	Route::get('rentalspaces/{id}/spacemap','RentalSpaceController@spaceMap');
	Route::patch('rentalspaces/{id}/spacemap','RentalSpaceController@updateMap');

	Route::resource('rentalareatypes','RentalAreaTypeController');
	Route::get('rentalareatypes/{id}/typemap','RentalAreaTypeController@typeMap');
	Route::patch('rentalareatypes/{id}/typemap','RentalAreaTypeController@updateMap');

	Route::resource('activities','ActivityController');
	Route::get('activities/{id}/participants','ActivityController@participants');
	Route::get('activities/{id}/participants/create','ActivityController@createParticipant');
	Route::patch('activities/{id}/participants/{participantId}/accept','ActivityController@acceptParticipant');
	Route::patch('activities/{id}/participants/{participantId}/deny','ActivityController@denyParticipant');
	Route::delete('activities/{id}/participants/{participantId}','ActivityController@destroyParticipant');

	Route::get('activities/{id}/participants/create','ActivityController@createParticipant');

	Route::resource('documenttypes', 'DocumentTypeController');
	Route::resource('announcements', 'AnnouncementController');
	Route::resource('mayorschedules', 'MayorScheduleController');

	Route::get('attendances', 'AttendanceController@index');
	Route::get('activedeductions', 'EmployeeActiveDeductionController@index');
	Route::get('payslips', 'MonthlyPayoutController@index');

	Route::resource('reservations', 'ReservationController');
	Route::patch('reservations/{id}/waive', 'ReservationController@waive');
	Route::resource('payments', 'PaymentController');

	Route::get('payments/{id}/proof', 'PaymentController@proof');
	Route::get('payments/{id}/proof/create', 'PaymentController@createProof');
	Route::get('payments/{id}/proof/{proofId}', 'PaymentController@showProof');
	Route::delete('payments/{id}/proof/{proofId}', 'PaymentController@destroyProof');
	Route::post('payments/{id}/uploadProof', 'PaymentController@uploadProof');
	Route::post('payments/{id}/removeFile', 'PaymentController@removeFile');

	Route::get('financialreport', 'ReportController@financial');

	Route::get('notifications/onhold', 'ReservationController@reservationOnHold');
});