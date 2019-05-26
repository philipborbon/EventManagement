<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;

class MonthlyPayout extends Model
{
	protected $fillable = ['userid', 'payout', 'actualpayout', 'dateavailable', 'datecollected'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}
}
