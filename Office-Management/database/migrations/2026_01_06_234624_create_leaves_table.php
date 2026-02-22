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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('duration_type');
            $table->date('from');
            $table->date('to');
            $table->string('leave_type');
            $table->string('description');
            $table->boolean('approve')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE leaves ADD CONSTRAINT duration_type CHECK (duration_type IN ('half', 'full'))");
        DB::statement("ALTER TABLE leaves ADD CONSTRAINT leave_type CHECK (leave_type IN ('casual', 'medical','casual'))");
        DB::statement('ALTER TABLE leaves ADD CONSTRAINT chk_approve CHECK (approve IN (0, 1) OR approve IS NULL)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
