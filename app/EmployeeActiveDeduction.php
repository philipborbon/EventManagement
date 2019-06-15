<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;
use EventManagement\DeductionType;

class EmployeeActiveDeduction extends Model
{
	protected $fillable = ['userid', 'typeid', 'amount'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

	public function type(){
		return $this->belongsTo(DeductionType::class, 'typeid');
	}
}
