<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Client;


class CarteFidelite extends Model
{
    protected $fillable = ['commercial_ID', 'points_sum', 'tier', 'name', 'fidelity_program'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


}
