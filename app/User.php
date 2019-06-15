<?php

namespace EventManagement;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use EventManagement\SalaryGrade;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'usertype', 'age', 'address', 'sex', 'maritalstatus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullname()
    {
      return "{$this->lastname}, {$this->firstname}";
    }

    public function getUserType(){
        $type = $this->usertype;

        $description = "";

        $types = config('enums.usertype');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
    }

    public function salaryGrade(){
        $this->hasOne(SalaryGrade::class, 'userid');
    }
}
