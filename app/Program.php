<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date','expiry_date', 'amount', 'points', 'minimum_amount','amount_premium', 'points_premium', 'minimum_amount_premium', 'conversion_factor', 'status', 'comment'];
}
