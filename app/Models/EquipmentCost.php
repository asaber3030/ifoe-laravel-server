<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCost extends Model
{
	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'equipment_costs';
	protected $fillable = ['value', 'unit_id'];

	public function unit()
	{
		return $this->belongsTo(Unit::class, 'unit_id', 'id');
	}
}
