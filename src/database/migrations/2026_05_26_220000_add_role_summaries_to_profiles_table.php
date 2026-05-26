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
            $table->text('professional_summary_id')->nullable()->after('summary_en');
            $table->text('professional_summary_en')->nullable()->after('professional_summary_id');
            $table->text('academic_summary_id')->nullable()->after('professional_summary_en');
            $table->text('academic_summary_en')->nullable()->after('academic_summary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'professional_summary_id',
                'professional_summary_en',
                'academic_summary_id',
                'academic_summary_en',
            ]);
        });
    }
};
