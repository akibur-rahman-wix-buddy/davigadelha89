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
        Schema::create('aboutuses', function (Blueprint $table) {
            $table->id();
            $table->text('whoweare')->nullable();
            $table->text('our_mission')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('logo')->nullable();
            $table->text('instagram')->nullable();
            $table->text('facebook')->nullable();
            $table->text('linkedin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aboutuses');
    }
};
