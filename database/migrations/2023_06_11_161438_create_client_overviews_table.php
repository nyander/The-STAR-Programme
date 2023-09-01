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
        Schema::create('client_overviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('performanceProfile_id')->default('1');
            $table->string('current_sport')->nullable(); // field by client
            $table->string('experience_level')->nullable(); // field by client
            $table->integer('rating')->default(0); // field by client
            $table->text('client_experience')->nullable(); // field by client
            $table->text('client_positive_feedback')->nullable(); // field by client
            $table->text('client_areas_to_improve')->nullable(); // field by client
            $table->text('client_challenges')->nullable(); // field by client
            $table->text('client_testimonies')->nullable(); // field by client
            $table->text('client_comments')->nullable(); // field by client
            $table->boolean('client_completion')->default(false);

            $table->text('practitioner_client_achieve')->nullable();
            $table->text('practitioner_progress_review')->nullable(); // field by practitioner
            $table->text('practitioner_achievement_review')->nullable(); // field by practitioner
            $table->text('practitioner_challenge_review')->nullable(); // field by practitioner
            $table->text('practitioner_support')->nullable(); // field by practitioner
            $table->text('practitioner_suggestion')->nullable(); // field by practitioner
            $table->boolean('practitioner_completion')->default(false);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('performanceProfile_id')->references('id')->on('performance_profile_templates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_overviews');
    }
};
