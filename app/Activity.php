<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $fillable = ['eventid', 'name', 'location', 'schedule'];
}
