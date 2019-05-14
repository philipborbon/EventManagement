<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\RentalSpace;

class RentalAreaType extends Model
{
	protected $fillable = ['name'];

	public function spaces()
	{
	  return $this->hasMany(RentalSpace::class, 'typeid');
	}
}
