<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{

	use SoftDeletes;

	protected $table = 'blogs';
	protected $fillable = ['blog_id', 'title', 'short_text', 'blog_content', 'image_url'];
}
