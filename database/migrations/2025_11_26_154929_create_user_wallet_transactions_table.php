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
        Schema::create('user_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_wallet_id')->constrained()->onDelete('cascade');
            $table->string('type'); // e.g., deposit, withdrawal, transfer
            $table->decimal('amount', 15, 2);
            $table->morphs('related'); // For transfers, this can be the recipient user
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wallet_transactions');
    }
};
