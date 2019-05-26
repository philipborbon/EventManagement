<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class MayorSchedule extends Model
{
	protected $fillable = ['name', 'schedule', 'status'];
}
