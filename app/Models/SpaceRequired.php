<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceRequired extends Model
{
  use SoftDeletes;

  public $timestamps = false;
  protected $table = 'space_required';
  protected $fillable = ['unit_id', 'value'];

  public function unit()
  {
    return $this->belongsTo(Unit::class, 'unit_id');
  }
}
