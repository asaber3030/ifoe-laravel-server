<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{

	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'units';
	protected $fillable = ['name'];
}
