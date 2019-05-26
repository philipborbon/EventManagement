<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;
use EventManagement\RentalSpace;
use EventManagement\Reservation;

class Payment extends Model
{
	protected $fillable = ['userid', 'rentalspaceid', 'reservationid', 'amount', 'verified'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

	public function rentalSpace(){
		return $this->belongsTo(RentalSpace::class, 'rentalspaceid');
	}

	public function reservation(){
		return $this->belongsTo(Reservation::class, 'reservationid');
	}
}
