<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorWallet extends Model
{
    protected $fillable = [
        'vendor_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(VendorWalletTransaction::class);
    }

    public function incrementBalance(float $amount, array $transactionData = []): VendorWalletTransaction
    {
        $this->increment('balance', $amount);
        return $this->recordTransaction('credit', $amount, $transactionData);
    }

    public function decrementBalance(float $amount, array $transactionData = []): ?VendorWalletTransaction
    {
        if ($this->balance < $amount) {
            return null; // Insufficient balance
        }
        
        $this->decrement('balance', $amount);
        return $this->recordTransaction('debit', $amount, $transactionData);
    }

    protected function recordTransaction(string $type, float $amount, array $data = []): VendorWalletTransaction
    {
        return $this->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'description' => $data['description'] ?? '',
            'status' => $data['status'] ?? 'completed',
            'reference' => $data['reference'] ?? 'TRX-' . time() . '-' . $this->id,
            'metadata' => $data['metadata'] ?? null,
        ]);
    }
}
