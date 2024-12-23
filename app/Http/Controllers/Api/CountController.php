<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use App\Models\Franchise;
use App\Models\Partner;
use Illuminate\Http\Request;

class CountController extends Controller
{
  public function counts()
  {
    return response()->json([
      'blogs' => Blog::count(),
      'users' => User::count(),
      'franchises' => Franchise::count(),
      'partners' => Partner::count(),
    ]);
  }
}
