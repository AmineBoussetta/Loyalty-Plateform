<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function card()
    {
        return $this->hasOne(CarteFidelite::class, 'client_id');
    }
}


