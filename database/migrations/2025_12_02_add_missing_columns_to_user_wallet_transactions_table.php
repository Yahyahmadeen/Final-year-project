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
        Schema::table('user_wallet_transactions', function (Blueprint $table) {
            // Change user_wallet_id to wallet_id to match the code
            $table->renameColumn('user_wallet_id', 'wallet_id');
            
            // Add reference column
            $table->string('reference')->nullable()->after('amount');
            
            // Add status column
            $table->string('status')->default('pending')->after('reference');
            
            // Change related to polymorphic relationship if needed, or keep as is
            // $table->nullableMorphs('related');
            
            // Add metadata as JSON column
            $table->json('metadata')->nullable()->after('description');
            
            // Add timestamps if not already present
            if (!Schema::hasColumn('user_wallet_transactions', 'created_at')) {
                $table->timestamps();
            }
            
            // Add index for better query performance
            $table->index(['wallet_id', 'type']);
            $table->index('reference');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_wallet_transactions', function (Blueprint $table) {
            $table->renameColumn('wallet_id', 'user_wallet_id');
            $table->dropColumn(['reference', 'status', 'metadata']);
            $table->dropIndex(['wallet_id', 'type']);
            $table->dropIndex(['reference']);
            $table->dropIndex(['status']);
            
            // If we added timestamps in up(), we should remove them in down()
            if (Schema::hasColumn('user_wallet_transactions', 'created_at')) {
                $table->dropTimestamps();
            }
        });
    }
};
