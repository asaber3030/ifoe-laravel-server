<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FranchiseType extends Model
{

	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'franchise_types';
	protected $fillable = ['franchise_type', 'city_of_opening', 'confirmation'];
}
