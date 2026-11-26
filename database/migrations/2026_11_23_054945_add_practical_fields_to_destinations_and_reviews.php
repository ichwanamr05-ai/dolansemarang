<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {$table->string('area')->nullable()->after('address');
            $table->string('budget_tier')->default('Terjangkau')->after('price_range');$table->unsignedInteger('estimated_cost')->default(0)->after('budget_tier');
            $table->string('best_time')->default('Fleksibel')->after('estimated_cost');$table->string('opening_hours')->nullable()->after('best_time');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->string('crowd_status')->nullable()->after('visit_period');$table->boolean('is_flagged')->default(false)->after('helpful_count');
        });

        Schema::table('threads', function (Blueprint $table) {$table->boolean('is_flagged')->default(false)->after('author_name');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {$table->dropColumn(['area', 'budget_tier', 'estimated_cost', 'best_time', 'opening_hours']);
        });

        Schema::table('reviews', function (Blueprint $table) {$table->dropColumn(['crowd_status', 'is_flagged']);
        });

        Schema::table('threads', function (Blueprint $table) {$table->dropColumn(['is_flagged']);
        });
    }
};