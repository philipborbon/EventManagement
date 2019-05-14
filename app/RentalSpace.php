<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\RentalAreaType;
use EventManagement\Event;

class RentalSpace extends Model
{
	protected $fillable = ['eventid', 'typeid', 'name', 'location', 'area', 'datecreated', 'status', 'amount'];

    public function type(){
        return $this->hasOne(RentalAreaType::class, 'id', 'typeid');
    }

    public function event(){
        return $this->belongsTo(Event::class, 'eventid');
    }

    public function getStatus(){
        $type = $this->status;

        $description = "";

        $types = config('enums.spacestatus');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
    }
}
