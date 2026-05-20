<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('environmental_logs', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->decimal('temperature_celsius', 5, 2);
            $table->unsignedTinyInteger('humidity_percent');
            $table->timestamp('logged_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('environmental_logs');
    }
};
