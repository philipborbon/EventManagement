<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;
use EventManagement\RentalSpace;
use EventManagement\Payment;

class Reservation extends Model
{
	protected $fillable = ['userid', 'rentalspaceid', 'status'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

	public function rentalSpace(){
		return $this->belongsTo(RentalSpace::class, 'rentalspaceid');
	}

	public function payment(){
	    return $this->hasOne(Payment::class, 'reservationid');
	}
}
