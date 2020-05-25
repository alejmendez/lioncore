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
            $table->string('company', 80)->nullable();
            $table->string('avatar', 80)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('room_telephone', 15)->nullable();
            $table->string('mobile_phone', 15)->nullable();
            $table->string('website', 15)->nullable();
            $table->string('languages', 15)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('nationality', 80)->nullable();
            $table->string('gender', 2)->nullable();
            $table->string('civil_status', 1)->nullable();
            $table->string('contact_options', 50)->nullable();
            $table->string('address', 80)->nullable();
            $table->string('address2', 80)->nullable();
            $table->string('postcode', 80)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('state', 80)->nullable();
            $table->string('country', 80)->nullable();
            $table->smallInteger('number_children')->nullable()->default(0);
            $table->string('observation', 255)->nullable();
            $table->string('blood_type', 5)->nullable();
            
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
