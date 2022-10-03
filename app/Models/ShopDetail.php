<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'cloth_types' => 'array',
    ];
}
