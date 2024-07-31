<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonInteresseAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_interesse_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_id')->nullable();
            $table->foreign('app_id')->references('id')->on('applications')->onDelete('SET NULL');
            $table->string('feedback');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('non_interesse_attributes');
    }
}
