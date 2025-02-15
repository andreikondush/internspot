<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('internship_tags', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('internship_id');

            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('internship_id')->references('id')->on('internships')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_tags');
    }
};
