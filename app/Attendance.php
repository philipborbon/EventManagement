<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;

class Attendance extends Model
{
	protected $fillable = ['userid', 'date', 'doublepay', 'status'];

	protected $dates = ['date'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

    public function getStatus(){
        $type = $this->status;

        $description = "";

        $types = config('enums.attendancestatus');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
    }
}
