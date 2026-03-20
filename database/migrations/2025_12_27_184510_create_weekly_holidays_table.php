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
        Schema::create('weekly_holidays', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day')->unique();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE weekly_holidays ADD CONSTRAINT weekday_check CHECK (day BETWEEN 1 AND 7)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_holidays');
    }
};
