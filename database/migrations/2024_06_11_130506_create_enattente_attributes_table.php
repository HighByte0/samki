<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnattenteAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enattente_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_id')->nullable();
            $table->foreign('app_id')->references('id')->on('applications')->onDelete('SET NULL');
            $table->date('follow_up_date');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('enattente_attributes');
    }
}
