<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseType extends Model
{
	protected $table = 'franchise_types';
	protected $fillable = ['franchise_type', 'city_of_opening', 'confirmation'];
}
