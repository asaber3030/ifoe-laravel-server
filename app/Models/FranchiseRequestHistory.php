<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FranchiseRequestHistory extends Model
{
	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'franchise_requests_history';
	protected $fillable = ['franchise_request_id', 'status', 'changed_at', 'changed_by', 'remarks'];

	public function request()
	{
		return $this->belongsTo(FranchiseRequest::class, 'franchise_request_id');
	}

	public function changedBy()
	{
		return $this->belongsTo(User::class, 'changed_by');
	}
}
