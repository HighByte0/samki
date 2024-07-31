<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    protected $table = 'emailparametre';

    protected $fillable = [
        'id',
        'user_id',
        'Email_Injoinable',
        'Email_Convocation',
        'Email_Proposition',
    ];
}
