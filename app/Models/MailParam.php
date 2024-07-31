<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailParam extends Model
{
    protected $table = 'emailparametre';
    protected $fillable=['Email_Injoinable','Email_Convocation','Email_Convocation']; 
    use HasFactory;

}
