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
        // Get the first user ID to assign existing records
        $firstUserId = DB::table('users')->orderBy('id')->value('id');
        
        if (!$firstUserId) {
            throw new \Exception('No users found in the database. Please create a user first.');
        }

        // Add user_id to projects table (nullable first to allow updates)
        Schema::table('projects', function (Blueprint $table) use ($firstUserId) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // Add user_id to tasks table (nullable first to allow updates)
        Schema::table('tasks', function (Blueprint $table) use ($firstUserId) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // Assign existing projects and tasks to the first user
        DB::table('projects')->whereNull('user_id')->update(['user_id' => $firstUserId]);
        DB::table('tasks')->whereNull('user_id')->update(['user_id' => $firstUserId]);

        // Now make columns required (not nullable) before adding foreign key
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });

        // Finally add the foreign key constraints
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
