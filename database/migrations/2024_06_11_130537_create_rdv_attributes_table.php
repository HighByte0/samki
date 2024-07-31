    <?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdvAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdv_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_id')->nullable(); // Define the foreign key column first
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('motif')->nullable();
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('app_id')->references('id')->on('applications')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rdv_attributes', function (Blueprint $table) {
            $table->dropForeign(['app_id']); // Drop the foreign key constraint first
        });
        Schema::dropIfExists('rdv_attributes'); // Then drop the table
    }
}
