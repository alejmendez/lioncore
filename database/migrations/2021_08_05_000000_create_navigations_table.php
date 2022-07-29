<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary('id');

            $table->string('title', 120);
            $table->string('subtitle', 120)->nullable();
            $table->string('type', 20);
            $table->string('tooltip', 120)->nullable();
            $table->string('link', 200)->nullable();
            $table->string('icon', 120)->nullable();
            $table->uuid('parent')->nullable();
            $table->integer('order')->default(0);
            $table->string('meta', 120)->nullable();

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
        Schema::dropIfExists('navigations');
    }
};
