<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperAdmin extends Authenticatable
{
    protected $table = 'caissiers';

    protected $fillable = ['user_id','$company_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
