<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;
use EventManagement\User;
use EventManagement\DocumentType;

class UserIdentification extends Model
{
	protected $fillable = ['userid', 'documenttypeid', 'attachment'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

	public function documentType(){
		return $this->belongsTo(DocumentType::class, 'documenttypeid');
	}
}
