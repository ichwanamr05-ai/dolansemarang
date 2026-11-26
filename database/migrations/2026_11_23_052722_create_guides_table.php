<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('badge');
            $table->string('title');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('author_name');
            $table->string('read_time')->default('5 menit baca');
            $table->unsignedInteger('likes_count')->default(0);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};