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
        Schema::table('orders', function (Blueprint $table) {
            // Add tracking fields if they don't exist
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'carrier')) {
                $table->string('carrier')->nullable()->after('tracking_number');
            }
            if (!Schema::hasColumn('orders', 'estimated_delivery')) {
                $table->timestamp('estimated_delivery')->nullable()->after('delivered_at');
            }
            if (!Schema::hasColumn('orders', 'processing_started_at')) {
                $table->timestamp('processing_started_at')->nullable()->after('estimated_delivery');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'carrier', 'estimated_delivery', 'processing_started_at']);
        });
    }
};
