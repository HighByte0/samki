<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdvAttribute extends Model
{
    use HasFactory;
    protected $table = "rdv_attributes";
    protected $fillable = ['app_id','appointment_date','appointment_time','motif'];
  
   
    public function status()
    {
        
        return $this->belongsTo(Status::class);
    }
}
