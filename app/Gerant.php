<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Gerant extends Authenticatable
{
    protected $table = 'gerants';


    protected $fillable = ['name', 'email', 'phone', 'company_id'];



    public function company()
{
    return $this->belongsTo(Company::class);
}


}