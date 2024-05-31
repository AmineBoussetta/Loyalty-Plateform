<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone','company_id', 'fidelity_card_id', 'money_spent'];

    public function carteFidelite()
    {
        return $this->hasOne(CarteFidelite::class, 'holder_id');
    }
    public function gerant()
    {
        return $this->belongsTo(Gerant::class);
    }
    public function caissier()
    {
        return $this->belongsTo(Caissier::class);
    }
    
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}


