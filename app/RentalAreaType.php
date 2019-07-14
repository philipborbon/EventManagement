<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\RentalSpace;
use EventManagement\RentalTypeArea;

class RentalAreaType extends Model
{
	protected $fillable = ['name'];

	public function spaces(){
	  return $this->hasMany(RentalSpace::class, 'typeid');
	}

    public function coordinates(){
        return $this->hasMany(RentalTypeArea::class, 'areatypeid');
    }
}
