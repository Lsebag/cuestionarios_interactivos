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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('access_code')->unique();
            $table->enum('status', ['waiting', 'started', 'finished'])->default('waiting');
            $table->string('meeting_name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // presenter
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
