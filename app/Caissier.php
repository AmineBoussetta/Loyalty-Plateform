<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Caissier extends Model
{    
    protected $fillable = ['Caissier_ID', 'name', 'email', 'phone', 'company_name','company_id'];

    // Relation avec le modèle User si nécessaire
    public function user()
    {
        return $this->belongsTo(User::class, 'company_name',);
    }
    public function gerant()
    {
        return $this->belongsTo(Gerant::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}

?>