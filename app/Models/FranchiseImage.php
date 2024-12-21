<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseImage extends Model
{
	protected $table = 'franchise_images';
	protected $fillable = ['franchise_id', 'image_url'];

	public function franchise()
	{
		return $this->belongsTo(Franchise::class, 'franchise_id');
	}
}
