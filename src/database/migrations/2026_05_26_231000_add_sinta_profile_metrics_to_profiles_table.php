<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->decimal('sinta_score_3yr', 10, 2)->nullable()->after('sinta_overall_score');
            $table->decimal('affil_score', 10, 2)->nullable()->after('sinta_score_3yr');
            $table->decimal('affil_score_3yr', 10, 2)->nullable()->after('affil_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'sinta_score_3yr',
                'affil_score',
                'affil_score_3yr',
            ]);
        });
    }
};
