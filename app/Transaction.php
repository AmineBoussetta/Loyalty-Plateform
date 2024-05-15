<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'carte_fidelite_id','transaction_date','amount','payment_method', 'points'];

    public function carteFidelite()
    {
        return $this->belongsTo(CarteFidelite::class, 'carte_fidelite_id');
    }
}
