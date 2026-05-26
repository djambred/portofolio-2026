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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('full_name', 120);
            $table->string('headline', 160);
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('current_city', 100)->nullable();
            $table->string('email', 150);
            $table->string('phone', 30);
            $table->text('summary_id')->nullable();
            $table->text('summary_en')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('website_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->enum('preferred_locale', ['id', 'en'])->default('id');
            $table->boolean('show_birth_date')->default(true);
            $table->enum('cv_status', ['draft', 'published'])->default('draft');
            $table->timestamp('last_published_at')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->enum('platform', ['linkedin', 'github', 'instagram', 'x', 'website', 'youtube', 'medium', 'other']);
            $table->string('label', 80);
            $table->string('url');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('company_name', 150);
            $table->string('position_title', 150);
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'internship', 'freelance']);
            $table->string('location', 120)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('tools_text')->nullable();
            $table->longText('description');
            $table->json('achievements_id')->nullable();
            $table->json('achievements_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('institution_name', 150);
            $table->string('degree', 120);
            $table->string('major', 120)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->decimal('gpa_scale', 3, 2)->default(4.00);
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->enum('category', ['programming', 'database', 'devops', 'analysis', 'networking', 'reporting', 'other'])->default('other');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('intermediate');
            $table->unsignedTinyInteger('proficiency_score')->nullable();
            $table->unsignedTinyInteger('years_of_experience')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('role', 120);
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->json('tech_stack')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('project_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->json('impact_metrics')->nullable();
            $table->boolean('show_on_landing')->default(true);
            $table->boolean('show_on_cv')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('name', 180);
            $table->string('issuer', 150);
            $table->date('issued_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->string('credential_id', 120)->nullable();
            $table->string('credential_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('name', 80);
            $table->enum('proficiency', ['native', 'fluent', 'professional', 'intermediate', 'basic'])->default('intermediate');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('career_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('title', 160);
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->string('metric_value', 80)->nullable();
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
        Schema::dropIfExists('career_highlights');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('work_experiences');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('profiles');
    }
};
