<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $fillable = ['name', 'description', 'startdate', 'enddate', 'status'];

    public function getStatus(){
        $type = $this->status;

        $description = "";

        $types = config('enums.eventstatus');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
    }
}
