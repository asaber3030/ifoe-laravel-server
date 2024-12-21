<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPeriod extends Model
{
	protected $table = 'contract_periods';
	protected $fillable = ['value', 'unit_id'];

	public function unit()
	{
		return $this->belongsTo(Unit::class, 'unit_id', 'id');
	}
}
