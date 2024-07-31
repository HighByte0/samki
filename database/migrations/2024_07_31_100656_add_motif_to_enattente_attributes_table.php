<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotifToEnattenteAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enattente_attributes', function (Blueprint $table) {
            $table->string('motif')->nullable(); // Add the 'motif' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enattente_attributes', function (Blueprint $table) {
            $table->dropColumn('motif');
        });
    }
}
