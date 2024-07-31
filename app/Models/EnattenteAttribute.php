<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnattenteAttribute extends Model
{
    use HasFactory;
    protected $table="enattente_attributes";
    protected $fillable=['app_id','follow_up_date','updated_at','created_at','appointment_time','motif']; 
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
