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
        Schema::create('car_stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('thumbnail');
            $table->text('address');
            $table->string('phone_number');
            $table->string('cs_name');
            $table->boolean('is_open');
            $table->boolean('is_full');
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_stores');
    }
};
