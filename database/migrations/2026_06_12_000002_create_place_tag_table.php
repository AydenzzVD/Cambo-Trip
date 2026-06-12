<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('place_tag', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();

            // Ensure unique associations
            $table->unique(['place_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_tag');
    }
};
