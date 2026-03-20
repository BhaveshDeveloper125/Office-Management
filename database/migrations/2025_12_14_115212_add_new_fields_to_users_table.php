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
        Schema::table('users', function (Blueprint $table) {
            $table->string('post')->after('email');
            $table->string('mobile')->unique()->after('post');
            $table->string('address')->after('mobile');
            $table->string('qualification')->after('address');
            $table->decimal('experience', 5, 2)->after('qualification');
            $table->date('joining')->after('experience');
            $table->time('working_from')->after('joining');
            $table->time('working_to')->after('working_from');
            $table->boolean('working')->default(true)->after('working_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['post', 'mobile', 'address', 'qualification', 'experience', 'joining', 'working_from', 'working_to', 'working']);
        });
    }
};
