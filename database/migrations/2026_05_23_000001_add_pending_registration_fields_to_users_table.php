<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds pending registration fields to users so the Student record
     * is NOT created until admin approves the registration.
     * Also cleans up any premature Student records for users still pending.
     */
    public function up(): void
    {
        // 1. Add pending registration columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('pending_class_id')->nullable()->after('status');
            $table->string('pending_parent_name')->nullable()->after('pending_class_id');
            $table->string('pending_parent_email')->nullable()->after('pending_parent_name');
            $table->string('pending_parent_phone')->nullable()->after('pending_parent_email');
        });

        // 2. For existing pending users: copy their class/parent data from the
        //    prematurely-created students record back onto the users row,
        //    then delete those students rows so they no longer appear as active students.
        $pendingUsers = DB::table('users')
            ->where('role', 'student')
            ->where('status', 'pending')
            ->get();

        foreach ($pendingUsers as $user) {
            $student = DB::table('students')
                ->where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->first();

            if ($student) {
                // Restore class/parent data to the users table
                DB::table('users')->where('id', $user->id)->update([
                    'pending_class_id'    => $student->class_id,
                    'pending_parent_name' => $student->parent_name,
                    'pending_parent_email'=> $student->parent_email ?? null,
                    'pending_parent_phone'=> $student->parent_phone,
                ]);

                // Soft-delete the premature student record so it disappears from all lists
                DB::table('students')
                    ->where('user_id', $user->id)
                    ->update(['deleted_at' => now()]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'pending_class_id',
                'pending_parent_name',
                'pending_parent_email',
                'pending_parent_phone',
            ]);
        });
    }
};
