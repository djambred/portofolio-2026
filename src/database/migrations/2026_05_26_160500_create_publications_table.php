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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('authors')->nullable();
            $table->string('journal_name', 180)->nullable();
            $table->string('publisher', 160)->nullable();
            $table->unsignedSmallInteger('publication_year')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('doi', 120)->nullable();
            $table->string('external_id', 100)->nullable();
            $table->string('sinta_url')->nullable();
            $table->decimal('sinta_score', 5, 2)->nullable();
            $table->string('sinta_quartile', 20)->nullable();
            $table->unsignedInteger('citation_count')->default(0);
            $table->enum('indexing_source', ['sinta', 'scopus', 'wos', 'google_scholar', 'other'])->default('sinta');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
