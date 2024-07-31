<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';
    protected $fillable = ['status_name'];

    public function condidatures()
    {
        return $this->hasMany(Application::class);
    }

    public function injoignableAttributes()
    {
        return $this->hasMany(InjoignableAttribute::class);
    }

    public function nonInteresseAttributes()
    {
        return $this->hasMany(NonInteresseAttribute::class);
    }

    public function enattenteAttributes()
    {
        return $this->hasMany(EnattenteAttribute::class);
    }

    public function negatifAttributes()
    {
        return $this->hasMany(NegatifAttribute::class);
    }

    public function rdvAttributes()
    {
        return $this->hasMany(RdvAttribute::class);
    }
    public function application()
    {
        return $this->hasMany(Application::class,);
    }
}
