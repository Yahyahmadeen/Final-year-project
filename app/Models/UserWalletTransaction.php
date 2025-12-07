<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['wallet_id', 'type', 'amount', 'related_type', 'related_id', 'description'];

    public function wallet()
    {
        return $this->belongsTo(UserWallet::class, 'wallet_id');
    }

    public function related()
    {
        return $this->morphTo();
    }


    // In UserWalletTransaction.php
    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:2'
    ];
}
