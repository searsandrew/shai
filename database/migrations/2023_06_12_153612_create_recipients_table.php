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
        Schema::create('recipients', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->foreignUlid('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('group_id')->constrained()->nullable();
            $table->string('external_id')->nullable();
            $table->string('name');
            $table->enum('privacy', ['obfuscate','standard','verbose'])->default('standard');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipients');
    }
};
