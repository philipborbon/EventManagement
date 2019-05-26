<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;

class Attendance extends Model
{
	protected $fillable = ['userid', 'date', 'ishalfday', 'doublepay', 'overtime', 'status'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}
}
