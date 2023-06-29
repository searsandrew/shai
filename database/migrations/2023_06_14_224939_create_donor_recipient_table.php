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
        Schema::create('donor_recipient', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('donor_id')->constrained();
            $table->foreignUlid('recipient_id')->constrained();
            $table->enum('status', ['claimed', 'notified', 'recieved'])->default('claimed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donor_recipient');
    }
};
