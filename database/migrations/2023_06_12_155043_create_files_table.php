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
        Schema::create('files', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->foreignUlid('campaign_id')->constrained();
            $table->string('name')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('type', ['attachment', 'upload'])->default('upload');
            $table->enum('status', ['new', 'processing', 'complete'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
