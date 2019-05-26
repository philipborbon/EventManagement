<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\MonthlyPayout;
use EventManagement\DeductionType;

class PayoutDeduction extends Model
{
	protected $fillable = ['payoutid', 'typeid', 'amount'];

	public function payout(){
		return $this->belongsTo(MonthlyPayout::class, 'payoutid');
	}

	public function type(){
		return $this->belongsTo(DeductionType::class, 'typeid');
	}
}
