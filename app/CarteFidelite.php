<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Client;

class CarteFidelite extends Model
{
    protected $fillable = ['commercial_ID', 'points_sum', 'tier','company_id', 'holder_name', 'fidelity_program', 'money', 'holder_id', 'program_id'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'holder_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', );
    }

}
