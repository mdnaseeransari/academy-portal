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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->enum('exam_type', ['unit_test', 'half_yearly', 'final', 'other']);
            $table->decimal('marks_obtained', 5, 2);
            $table->decimal('total_marks', 5, 2);
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
