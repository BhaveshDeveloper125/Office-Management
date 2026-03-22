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
        Schema::create('user_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('leaves')->unsigned()->default(0);

            $table->date('year');
            $table->integer('year_extracted')->virtualAs('YEAR(year)'); //This is virtual column which is not the real column , its value are calculated from the year column
            $table->unique(['user_id', 'year_extracted']); //Unique constrained is applied on the user_id and year_extracted , in all row both combine value must be unique

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leaves');
    }
};
