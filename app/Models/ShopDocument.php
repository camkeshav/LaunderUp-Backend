<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopDocument extends Model
{
    use HasFactory;
    protected $fillable = ["verified_at"];
}
