<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\RentalAreaType;

class RentalTypeArea extends Model
{
	protected $fillable = ['areatypeid', 'latitude', 'longitude'];

	protected $casts = [
	    'latitude' => 'float',
	    'longitude' => 'float'
	];

	public function areaType(){
		return $this->belongsTo(RentalAreaType::class, 'areatypeid');
	}
}
