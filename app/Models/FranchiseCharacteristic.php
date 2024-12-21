<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseCharacteristic extends Model
{
	protected $table = 'franchise_characteristics';
	protected $fillable = ['franchise_fees', 'royalty_fees', 'marketing_fees', 'investments_cost'];
}
