<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'partners';
	protected $fillable = ['image_url'];
}
