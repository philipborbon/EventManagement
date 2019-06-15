<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\Activity;

class Event extends Model
{
	protected $fillable = ['name', 'description', 'startdate', 'enddate', 'status'];

    protected $dates = ['startdate', 'enddate'];

    public function getStatus(){
        $type = $this->status;

        $description = "";

        $types = config('enums.schedulestatus');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
    }

    public function activities(){
        return $this->hasMany(Activity::class, 'eventid');
    }
}
