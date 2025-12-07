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
        Schema::create('vendor_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->decimal('balance', 12, 2)->default(0);
            $table->timestamps();
            
            $table->unique('vendor_id');
        });
        
        // Create transactions table for vendor wallet
        Schema::create('vendor_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_wallet_id')->constrained()->onDelete('cascade');
            $table->string('type'); // credit or debit
            $table->decimal('amount', 12, 2);
            $table->string('description');
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('reference')->unique();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_wallet_transactions');
        Schema::dropIfExists('vendor_wallets');
    }
};
