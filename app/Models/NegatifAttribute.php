<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegatifAttribute extends Model
{
    use HasFactory;
    protected $table="negatif_attributes";
    protected $fillable=["app_id","reason",	"created_at",	"updated_at"];
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
