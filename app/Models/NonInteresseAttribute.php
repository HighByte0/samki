<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonInteresseAttribute extends Model
{

    protected $table="non_interesse_attributes";
    protected $fillable=["app_id","feedback","created_at","updated_at"];

    use HasFactory;
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
