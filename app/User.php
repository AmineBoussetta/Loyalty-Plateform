<?php

namespace App;

use App\Gerant;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email','role', 'password','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->name} {$this->last_name}";
    }

    public function gerant()
{
    return $this->hasOne(Gerant::class);
}
public function caissier()
    {
        return $this->hasOne(Caissier::class, 'Caissier_ID','user_id'); // user_id est la clé étrangère dans la table caissiers
    }


    public function cartesFidelite()
    {
        return $this->hasMany(CarteFidelite::class, 'holder_id', 'id'); // Remplacez 'id_user' par la clé étrangère appropriée dans la table 'cartefidelite'
    }
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    
}




