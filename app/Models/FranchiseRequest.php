<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FranchiseRequest extends Model
{
	use SoftDeletes;

	protected $table = 'franchise_requests';
	protected $fillable = [
		'user_id',
		'franchise_id',
		'full_name',
		'phone',
		'country_id',
		'city',
		'company_name',
		'business_type',
		'have_experience',
		'franchise_type_id',
		'status'
	];

	public function history()
	{
		return $this->hasMany(FranchiseRequestHistory::class, 'franchise_request_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function franchise()
	{
		return $this->belongsTo(Franchise::class, 'franchise_id');
	}

	public function country()
	{
		return $this->belongsTo(Country::class, 'country_id');
	}

	public function type()
	{
		return $this->belongsTo(FranchiseType::class, 'franchise_type_id');
	}
}
