<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{ use HasFactory;
     protected $fillable = ['id','client_id','nom du caissier','type','amount','transaction_date','description','payment_method','status'];

    // Relation avec le modèle Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Accesseur pour formater la date de transaction
    public function getFormattedTransactionDateAttribute()
    {
        return $this->transaction_date->format('Y-m-d H:i:s');
    }

    // Méthode de requête pour récupérer les transactions d'un certain type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Méthode de validation pour valider que le montant est supérieur à zéro
    public function validateAmount()
    {
        return $this->amount > 0;
    }
}
