<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Caissier extends Model
{    
protected $fillable = ['Caissier_ID', 'name', 'email', 'phone', 'company_name','company_id','user_id'];

    public function gerant()
    {
        return $this->belongsTo(Gerant::class);
    }
    

    // Relation avec la table des clients
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // user_id est la clé étrangère dans la table caissiers
    }

    // Relation avec le modèle Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}

?>