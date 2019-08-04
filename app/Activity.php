<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\Event;
use EventManagement\EventParticipant;

class Activity extends Model
{
	protected $fillable = ['eventid', 'name', 'location', 'schedule'];

	protected $dates = ['schedule'];

    public function event(){
    	return $this->belongsTo(Event::class, 'eventid');
    }

    public function participants(){
        return $this->hasMany(EventParticipant::class, 'activityid', 'id');
    }
}
