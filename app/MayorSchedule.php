<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class MayorSchedule extends Model
{
	protected $fillable = ['name', 'schedule', 'location', 'status'];

    public function getStatus(){
        $type = $this->status;

        $description = "";

        $types = config('enums.schedulestatus');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
    }
}
