<?php

use App\Admin;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('document_type');
            $table->string('document_number');
            $table->string('name');
            $table->string('lastname');
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')
                ->references('id')
                ->on('states');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
            $table->unsignedBigInteger('parish_id')->nullable();
            $table->foreign('parish_id')
                ->references('id')
                ->on('parishes');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('treatment')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->string('timezone')->nullable();
            $table->string('ip')->nullable();
            $table->string('browser')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('admins');
    }
}
