<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary('id');

            $table->uuid('alumno_id');
            $table->string('title', 250);
            $table->string('tutor', 50);
            $table->boolean('consultancies');
            $table->boolean('documentation');
            $table->boolean('assignedDate');
            $table->boolean('presentation');
            $table->boolean('finalTome');

            $table->foreign('alumno_id')
                ->references('id')
                ->on('alumnos')
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
        Schema::dropIfExists('registros');
    }
}
