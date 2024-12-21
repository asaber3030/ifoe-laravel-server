<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentCost extends Model
{
	protected $table = 'equipment_costs';

	protected $fillable = ['value', 'unit_id'];

	public function unit()
	{
		return $this->belongsTo(Unit::class, 'unit_id', 'id');
	}
}
