<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary('id');

            $table->string('dni', 15)->nullable();
            $table->string('first_name', 80)->nullable();
            $table->string('last_name', 80)->nullable();
            $table->string('address', 80)->nullable();

            $table->date('birthdate')->nullable();
            $table->string('civil_status', 20)->nullable();
            $table->string('room_telephone', 15)->nullable();
            $table->string('mobile_phone', 15)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('nationality', 80)->nullable();

            $table->string('gender', 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('shirt_size', 2)->nullable();
            $table->string('size_pants', 2)->nullable();
            $table->string('shoe_size', 2)->nullable();
            $table->string('profession', 80)->nullable();
            $table->string('academic_level', 80)->nullable();

            $table->string('country', 80)->nullable();
            $table->string('state', 80)->nullable();
            $table->string('municipality', 80)->nullable();
            $table->string('parish', 80)->nullable();

            $table->string('military_component', 80)->nullable();
            $table->string('military_rank', 80)->nullable();

            $table->smallInteger('number_children', 80)->default(0);
            $table->string('spouse_works', 80)->nullable();
            $table->string('observation', 255)->nullable();

            $table->string('photos', 255)->nullable();
            $table->string('turn', 80)->nullable();
            $table->string('schedule', 80)->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('file_number', 80)->nullable();
            $table->string('management', 80)->nullable();

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
        Schema::dropIfExists('people');
    }
}
