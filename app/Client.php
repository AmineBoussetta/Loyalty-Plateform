<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'fidelity_card_id', 'money_spent'];

    public function carteFidelite()
    {
        return $this->hasOne(CarteFidelite::class, 'holder_id');
    }
}


