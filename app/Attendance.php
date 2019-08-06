<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;

use Carbon\Carbon;

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

    public function getTotalHours(){
        $amMinutes = 0;
        $pmMinutes = 0;

        if ($this->amin && $this->amout) {
            $amMinutes = (new Carbon($this->amin))->diffInMinutes(new Carbon($this->amout));
        }

        if ($this->pmin && $this->pmout) {
            $pmMinutes = (new Carbon($this->pmin))->diffInMinutes(new Carbon($this->pmout));
        }

        return ($amMinutes + $pmMinutes) / 60;
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
