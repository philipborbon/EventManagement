<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;

class Attendance extends Model
{
	protected $fillable = ['userid', 'date', 'doublepay', 'status', 'amin', 'amout', 'pmin', 'pmout'];

	protected $dates = ['date'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

    public function getAmIn(){
        return new \DateTime($this->amin);
    }

    public function getAmOut(){
        return new \DateTime($this->amout);
    }

    public function getPmIn(){
        return new \DateTime($this->pmin);
    }

    public function getPmOut(){
        return new \DateTime($this->pmout);
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
