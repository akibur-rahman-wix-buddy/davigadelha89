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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); 
            $table->string('title'); 
            $table->text('description'); 
            $table->string('video')->nullable(); 
            $table->integer('total_yoga')->nullable(); 
            $table->integer('break_time')->nullable(); 
            $table->integer('exercise_time')->nullable(); 
            $table->string('morning_meal')->nullable(); 
            $table->string('lunch_meal')->nullable(); 
            $table->string('workout_snack')->nullable(); 
            $table->string('dinner_meal')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
