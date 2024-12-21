<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise extends Model
{

	use SoftDeletes;

	protected $table = 'franchises';
	protected $fillable = [
		'name',
		'description',
		'equipment_cost_id',
		'category_id',
		'country_id',
		'image_url',
		'number_of_branches',
		'space_required_id',
		'number_of_labors',
		'training_period_id',
		'establish_year',
		'center_office',
		'franchise_characteristics_id',
		'contract_period_id',
		'added_by'
	];

	public function equipmentCost()
	{
		return $this->belongsTo(EquipmentCost::class, 'equipment_cost_id');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}

	public function country()
	{
		return $this->belongsTo(Country::class, 'country_id');
	}

	public function spaceRequired()
	{
		return $this->belongsTo(SpaceRequired::class, 'space_required_id');
	}

	public function trainingPeriod()
	{
		return $this->belongsTo(TrainingPeriod::class, 'training_period_id');
	}

	public function franchiseCharacteristic()
	{
		return $this->belongsTo(FranchiseCharacteristic::class, 'franchise_characteristics_id');
	}

	public function contractPeriod()
	{
		return $this->belongsTo(ContractPeriod::class, 'contract_period_id');
	}

	public function addedBy()
	{
		return $this->belongsTo(User::class, 'added_by');
	}
}
