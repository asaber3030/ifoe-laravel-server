<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

	use SoftDeletes;

	public $timestamps = false;
	protected $table = 'roles';
	protected $fillable = ['name'];

	public function users()
	{
		return $this->hasMany(User::class, 'user_id');
	}
}
