<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildingresidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('residentid');
            $table->foreign('residentid')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('subadminid');
            $table->foreign('subadminid')->references('id')->on('users')->onDelete('cascade');

            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('buildingname');

            $table->string('floorname');

            $table->unsignedBigInteger('apartmentid');
            $table->foreign('apartmentid')->references('id')->on('apartments')->onDelete('cascade');

            $table->string('houseaddress');
            $table->string('vechileno');
            $table->string('residenttype');
            $table->string('propertytype');
            $table->integer('committeemember');
            $table->integer('status');

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
        Schema::dropIfExists('buildingresidents');
    }
};
