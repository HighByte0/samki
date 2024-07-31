<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InjoignableAttribute extends Model

{
    protected $table='injoignable_attributes';
    protected $fillable=['app_id','reason']; 
    use HasFactory;
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
