<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Clean up duplicate records keeping the latest entry for each student+class+date+slot combo
        $duplicates = DB::table('attendance')
            ->select('student_id', 'class_id', 'date', 'period_slot', DB::raw('MAX(id) as max_id'))
            ->groupBy('student_id', 'class_id', 'date', 'period_slot')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('attendance')
                ->where('student_id', $duplicate->student_id)
                ->where('class_id', $duplicate->class_id)
                ->where('date', $duplicate->date)
                ->where('period_slot', $duplicate->period_slot)
                ->where('id', '<', $duplicate->max_id)
                ->delete();
        }

        // 2. Add database unique constraint
        Schema::table('attendance', function (Blueprint $table) {
            $table->unique(['student_id', 'class_id', 'date', 'period_slot'], 'attendance_unique_slot_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropUnique('attendance_unique_slot_idx');
        });
    }
};
