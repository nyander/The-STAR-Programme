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
        Schema::create('client_enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->text('subject');
            $table->text('content');
            $table->boolean('resolved')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_enquiries');
    }
};
