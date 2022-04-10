<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('horse_id');
            $table->unsignedBigInteger('career_id');
            $table->foreign('career_id')
                ->references('id')
                ->on('careers');
            $table->foreign('horse_id')
                ->references('id')
                ->on('horses');
            $table->unsignedBigInteger('jockey_id')->nullable();
            $table->foreign('jockey_id')
                ->references('id')
                ->on('jockeys');
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->foreign('trainer_id')
                ->references('id')
                ->on('trainers');
            $table->json('studs')->nullable();
            $table->decimal('weight')->nullable();
            $table->string('medicines')->nullable();
            $table->string('implements')->nullable();
            $table->string('number')->nullable();
            $table->string('position')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('odd', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptions');
    }
}
