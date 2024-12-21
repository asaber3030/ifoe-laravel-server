<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceRequired extends Model
{
  protected $table = 'space_required';
  protected $fillable = ['unit_id', 'value'];

  public function unit()
  {
    return $this->belongsTo(Unit::class, 'unit_id');
  }
}
