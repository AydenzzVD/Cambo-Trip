<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Activities
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        // Foods
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Hotels
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->string('map_link')->nullable();
            $table->timestamps();
        });

        // Restaurants
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('map_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('foods');
        Schema::dropIfExists('activities');
    }
};
