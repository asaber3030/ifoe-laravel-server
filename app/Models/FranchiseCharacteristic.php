<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FranchiseCharacteristic extends Model
{

	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'franchise_characteristics';
	protected $fillable = ['franchise_fees', 'royalty_fees', 'marketing_fees', 'investments_cost'];
}
