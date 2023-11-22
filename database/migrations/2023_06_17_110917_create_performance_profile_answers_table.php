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
        Schema::create('performance_profile_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performance_profile_id')->constrained('performance_profiles')->onDelete('cascade');
            $table->foreignId('question_id')->nullable()->constrained('performance_template_questions')->onDelete('set null');
            $table->text('question_text');
            $table->string('question_type');
            $table->text('answers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_profile_answers');
    }
};
