<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractPeriod extends Model
{

	use SoftDeletes;

	public $timestamps = false;

	protected $table = 'contract_periods';
	protected $fillable = ['value', 'unit_id'];

	public function unit()
	{
		return $this->belongsTo(Unit::class, 'unit_id', 'id');
	}
}
