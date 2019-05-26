<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;
use EventManagement\RentalSpace;

class Reservation extends Model
{
	protected $fillable = ['userid', 'rentalspaceid', 'status'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

	public function rentalSpace(){
		return $this->belongsTo(RentalSpace::class, 'rentalspaceid');
	}
}
