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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('external_id');
            $table->string('external_budget_id');
            $table->string('external_route_id');
            $table->string('track_id')->nullable();
            $table->string('name')->nullable();
            $table->string('notes')->nullable();
            $table->date('timestamp');
            $table->string('arrival_address');
            $table->timestamp('arrival_timestamp');
            $table->string('departure_address');
            $table->timestamp('departure_timestamp');
            $table->integer('capacity');
            $table->integer('confirmed_pax_count');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
