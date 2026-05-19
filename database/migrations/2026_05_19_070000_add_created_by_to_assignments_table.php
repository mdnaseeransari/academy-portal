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
        Schema::table('assignments', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('teacher_id');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Copy existing teacher_id (which references users.id) to created_by
        DB::statement('UPDATE assignments SET created_by = teacher_id WHERE teacher_id IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
