<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
	protected $fillable = ['name', 'description'];
}
