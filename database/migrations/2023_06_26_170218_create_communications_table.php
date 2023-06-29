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
        Schema::create('communications', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->bigInteger('donor_recipient_id')->unsigned();
            $table->foreign('donor_recipient_id')->references('id')->on('donor_recipient');
            $table->enum('type', ['selection', 'reminder', 'completion'])->default('selection');
            $table->text('payload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
