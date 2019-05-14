<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\Event;

class Activity extends Model
{
	protected $fillable = ['eventid', 'name', 'location', 'schedule'];

    public function event(){
    	return $this->belongsTo(Event::class, 'eventid');
    }
}
