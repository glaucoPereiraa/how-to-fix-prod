<?php

namespace App\Models;

use App\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
        'type',
    ];

    protected $casts = [
        'type' => TransactionTypeEnum::class
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
