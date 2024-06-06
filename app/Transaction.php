<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'carte_fidelite_id','client_id','company_id', 'transaction_date','amount', 'amount_spent', 'payment_method','status', 'points','caissier_id'];

    public function carteFidelite()
    {
        return $this->belongsTo(CarteFidelite::class, 'carte_fidelite_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
