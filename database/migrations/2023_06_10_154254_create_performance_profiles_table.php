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
        Schema::create('performance_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performance_template_id')->constrained('performance_template_questions')->onDelete('cascade'); //revise whether if the template is deleted, should this also be deleted
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('practitioner_id')->nullable()->constrained('users');
            $table->text('practitioner_feedback')->nullable();
            $table->text('strengths')->nullable();
            $table->text('weakness')->nullable();
            $table->integer('session')->default(1);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_profiles');
    }
};
