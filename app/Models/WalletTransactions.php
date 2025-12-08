<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransactions extends Model
{
    //
    protected $fillable = [
        'vendor_id', 'order_id', 'transaction_type', 'amount',
        'balance_before', 'balance_after', 'description', 'reference', 'status'
    ];
}
