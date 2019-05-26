<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\Activity;

class EventParticipant extends Model
{
	protected $fillable = ['activityid', 'firstname', 'lastname', 'age', 'sex', 'address'];

	public function activity(){
		return $this->belongsTo(Activity::class, 'activityid');
	}
}
