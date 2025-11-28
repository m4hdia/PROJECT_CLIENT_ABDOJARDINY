<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Sender & Receiver
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');

            // Message content
            $table->text('content');

            // Read status
            $table->boolean('is_read')->default(false);

            $table->timestamps();

            // Foreign Keys
            $table->foreign('sender_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('receiver_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
