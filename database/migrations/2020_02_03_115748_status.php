<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Status extends Migration
{
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('status_name');
            $table->timestamps();
        }); 
    }
    
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
