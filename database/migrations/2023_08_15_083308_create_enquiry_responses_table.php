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
        Schema::create('enquiry_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enquiry_id');
            $table->text('response');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_client_reply')->default(false); // For tracking client replies
            $table->timestamps();
            $table->foreign('enquiry_id')->references('id')->on('client_enquiries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry_responses');
    }
};
