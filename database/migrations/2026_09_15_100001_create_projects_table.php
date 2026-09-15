<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('excerpt', 300);
            $table->text('task')->nullable();
            $table->text('solution')->nullable();
            $table->text('result')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_concept')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
