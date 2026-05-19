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
        Schema::table('marks', function (Blueprint $table) {
            $table->date('date')->nullable()->after('subject');
            $table->string('topic')->nullable()->after('date');
        });

        // Convert enum to varchar to safely allow new exam types without breaking existing ones
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE marks MODIFY COLUMN exam_type VARCHAR(255) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn(['date', 'topic']);
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE marks MODIFY COLUMN exam_type ENUM('unit_test', 'half_yearly', 'final', 'other') NOT NULL");
    }
};
