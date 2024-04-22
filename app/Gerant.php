<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Gerant extends Authenticatable
{
    protected $table = 'gerants';

    protected $fillable = ['company_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
