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
        Schema::create('performance_template_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performance_template_id')->constrained('performance_profile_templates', 'id')->onDelete('cascade');
            $table->text('title');
            $table->foreignId('performance_categories');
            $table->text('text');
            $table->string('type');
            $table->json('options')->nullable();
            $table->boolean('required')->default(false);
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_template_questions');
    }
};
