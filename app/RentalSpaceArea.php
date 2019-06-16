<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\RentalSpace;

class RentalSpaceArea extends Model
{
	protected $fillable = ['rentalspaceid', 'latitude', 'longitude'];

	protected $casts = [
	    'latitude' => 'float',
	    'longitude' => 'float'
	];

	public function rentalSpace(){
		return $this->belongsTo(RentalSpace::class, 'rentalspaceid');
	}	
}
