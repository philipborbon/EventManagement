<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $fillable = ['description', 'location', 'date'];
}
