<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;

class SalaryGrade extends Model
{
    protected $fillable = [
    	'userid', 'dailypay'
    ];


    public function user(){
    	return $this->belongsTo(User::class, 'userid');
    }
}
