<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class jobsOff extends Migration
{
    public function up()
    {
        Schema::create('main_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('company');
                $table->float('salary', 10, 2)->default(0.00);
                $table->longText('description')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                
                // Job offers specific fields
                $table->json('profil')->nullable(); // Use JSON column for array-like data
                $table->text('job_description');
                $table->text('profile_description');
                $table->boolean('experience')->default(false);
                $table->text('other_information')->nullable();
                $table->json('languages')->nullable(); // Use JSON column for array-like data
                $table->string('working_hours')->nullable();
                $table->string('email');
                $table->string('site')->nullable();

                // Foreign key to users table
                $table->unsignedBigInteger('user_id');  
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('main_jobs');
    }
}
