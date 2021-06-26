<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary('id');

            $table->uuid('person_id')->unique();
            $table->string('code', 20)->nullable();
            $table->string('position', 50)->nullable();
            $table->string('group_id', 36)->nullable();
            $table->date('date_admission', 20)->nullable();
            $table->decimal('salary', 20)->nullable();

            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
