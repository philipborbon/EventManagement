<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class RentalSpace extends Model
{
	protected $fillable = ['description', 'location', 'area', 'datecreated', 'available', 'amount'];
}
