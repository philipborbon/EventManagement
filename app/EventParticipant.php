<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\Activity;
use EventManagement\User;

class EventParticipant extends Model
{
	protected $fillable = ['activityid', 'userid', 'accepted', 'denied'];

	public function activity(){
		return $this->belongsTo(Activity::class, 'activityid');
	}

    public function user(){
        return $this->belongsTo(User::class, 'userid');
    }
}
