<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Applications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['Homme', 'Femme'])->nullable();
            $table->string('telephone');
            $table->string('ville');
            $table->text('experience');
            $table->unsignedBigInteger('status_id');
            $table->string('slug');
            $table->string('email')->unique();
            $table->string('cv');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            // Add foreign key constraints if necessary
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('job_id')->references('id')->on('main_jobs');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('your_table_name');
    }
}
