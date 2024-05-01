<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Company extends Model
{
    protected $fillable = ['name', 'abbreviation', 'default_currency', 'country', 'tax_id', 'managers', 'phone', 'email', 'website', 'description'];
}
