<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class DeductionType extends Model
{
	protected $fillable = ['name', 'description'];
}
