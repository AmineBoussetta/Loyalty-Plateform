<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Gerant extends Authenticatable
{
    protected $table = 'gerants';


    protected $fillable = ['name', 'email', 'phone','user_id', 'company_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->onDelete('cascade');
    }
    public function caissiers()
    {
        return $this->hasMany(Caissier::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->onDelete('cascade');
    }
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
 


}
?>