<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;
use EventManagement\PayoutDeduction;

class MonthlyPayout extends Model
{
	protected $fillable = ['userid', 'payout', 'actualpayout', 'dateavailable', 'datecollected'];

	protected $dates = ['dateavailable', 'datecollected'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

	public function deductions(){
		return $this->hasMany(PayoutDeduction::class, 'payoutid');
	}

	public function deductionTotal(){
		$total = 0.0;
		foreach($this->deductions as $deduction){
			$total += (double) $deduction->amount;
		}

		return $total;
	}
}
