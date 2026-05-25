<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE marks DROP CONSTRAINT IF EXISTS marks_exam_type_check');
            DB::statement('ALTER TABLE marks ALTER COLUMN exam_type TYPE varchar(255)');
            DB::statement('DROP TYPE IF EXISTS enum_marks_exam_type');
        } else {
            Schema::table('marks', function (Blueprint $table) {
                $table->string('exam_type')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("CREATE TYPE enum_marks_exam_type AS ENUM ('unit_test', 'half_yearly', 'final', 'other')");
            DB::statement('ALTER TABLE marks ALTER COLUMN exam_type TYPE enum_marks_exam_type USING exam_type::text::enum_marks_exam_type');
        } else {
            Schema::table('marks', function (Blueprint $table) {
                $table->enum('exam_type', ['unit_test', 'half_yearly', 'final', 'other'])->change();
            });
        }
    }
};
