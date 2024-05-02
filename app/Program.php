<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date','expiry_date','tier','amount', 'points','status', 'minimum_amount', 'conversion_factor', 'comment'];
}
