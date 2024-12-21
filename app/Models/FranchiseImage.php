<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FranchiseImage extends Model
{

	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'franchise_images';
	protected $fillable = ['franchise_id', 'image_url'];

	public function franchise()
	{
		return $this->belongsTo(Franchise::class, 'franchise_id');
	}
}
