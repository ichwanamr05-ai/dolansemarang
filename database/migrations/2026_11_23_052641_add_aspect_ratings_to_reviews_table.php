<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->tinyInteger('rating_scenery')->nullable()->after('rating');
            $table->tinyInteger('rating_access')->nullable()->after('rating_scenery');
            $table->tinyInteger('rating_cleanliness')->nullable()->after('rating_access');
            $table->tinyInteger('rating_facilities')->nullable()->after('rating_cleanliness');
            $table->unsignedInteger('helpful_count')->default(0)->after('photo_url');
            $table->string('visit_period')->nullable()->after('helpful_count');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'rating_scenery',
                'rating_access',
                'rating_cleanliness',
                'rating_facilities',
                'helpful_count',
                'visit_period',
            ]);
        });
    }
};