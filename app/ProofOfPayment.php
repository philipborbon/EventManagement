<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\Payment;
use EventManagement\DocumentType;

class ProofOfPayment extends Model
{
	protected $fillable = ['paymentid', 'documenttypeid', 'attachment'];

	public function payment(){
		return $this->belongsTo(Payment::class, 'paymentid');
	}

	public function documentType(){
		return $this->belongsTo(DocumentType::class, 'documenttypeid');
	}
}
