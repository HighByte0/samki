<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [ 'nom',
    'prenom',
    'sexe',
    'telephone',
    'ville',
    'experience',
    'status_id',
    'slug',
    'email',
    'cv',
    'job_id',
    'user_id',
    'created_at',
    'updated_at',];
    public function job()
    {   
        return $this->belongsTo('App\Models\MainJob');
    }
    
    public function mainJob()
    {
        return $this->belongsTo(MainJob::class, 'user_id');
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class,'status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function enattenteAttributes()
    {
        return $this->hasOne(EnattenteAttribute::class, 'app_id');
    }

    public function injoignableAttributes()
    {
        return $this->hasOne(InjoignableAttribute::class, 'app_id');
    }

    public function negatifAttributes()
    {
        return $this->hasOne(NegatifAttribute::class, 'app_id');
    }

    public function nonInteresseAttributes()
    {
        return $this->hasOne(NonInteresseAttribute::class, 'app_id');
    }

    public function rdvAttributes()
    {
        return $this->hasOne(RdvAttribute::class, 'app_id');
    }
    
    public function getMotifAttribute()
    {
        switch ($this->status_id) {
            case 1:
                return $this->rdvAttributes->motif ?? 'No Motif Found';
            case 2:
                return $this->injoignableAttributes->reason ?? 'No Motif Found';
            case 3:
                return $this->nonInteresseAttributes->feedback ?? 'No Motif Found';
            case 4:
                return $this->enattenteAttributes->motif ?? 'No Motif Found';
            case 5:
                return $this->negatifAttributes->reason ?? 'No Motif Found';
            default:
                return 'No Motif Found';
        }
    }
}
