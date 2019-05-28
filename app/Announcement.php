<?php

namespace EventManagement;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
	protected $fillable = ['headline', 'description', 'active'];
}
