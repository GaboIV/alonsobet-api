<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Horse;

class CreateHorsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('sex')->nullable();
            $table->string('breed')->nullable();
            $table->string('color')->nullable();
            $table->text('jacket_url')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('father_id')->nullable();
            // $table->foreign('father_id')
            //     ->references('id')
            //     ->on('horses');
            $table->unsignedBigInteger('mother_id')->nullable();
            // $table->foreign('mother_id')
            //     ->references('id')
            //     ->on('horses');
            $table->unsignedBigInteger('grandpa')->nullable();
            // $table->foreign('grandpa')
            //     ->references('id')
            //     ->on('horses');
            $table->unsignedBigInteger('haras_id')->nullable();
            // $table->foreign('haras_id')
            //     ->references('id')
            //     ->on('haras');
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
        Schema::dropIfExists('horses');
    }
}
