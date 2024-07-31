<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainJob extends Model
{
    use HasFactory;
      protected $fillable = [
        'title',
        'company',
        'salary',
        'description',
        'status',
        'profil',
        'job_description',
        'profile_description',
        'experience',
        'other_information',
        'languages',
        'working_hours',
        'email',
        'site',
        'user_id',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }
    
}



