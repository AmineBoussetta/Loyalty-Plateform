<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteFidelite extends Model
{
    protected $fillable = ['commercial_ID', 'points_sum', 'tier', 'name'];
}
