<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    protected $fillable = ['name', 'abbreviation', 'default_currency', 'country', 'tax_id', 'phone', 'email', 'website', 'description'];

    public function gerants()
    {
        return $this->hasMany(Gerant::class);
    }
}