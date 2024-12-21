<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingPeriod extends Model
{
	protected $table = 'training_periods';
	protected $fillable = ['unit_id', 'value'];

	public function unit()
	{
		return $this->belongsTo(Unit::class, 'unit_id');
	}
}
