<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary('id');

            $table->string('firstName', 50);
            $table->string('lastname', 50);
            $table->string('phone', 50);
            $table->string('email', 80)->nullable();
            $table->string('specialty', 50);
            $table->string('semester', 50);
            
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
        Schema::dropIfExists('alumnos');
    }
}
