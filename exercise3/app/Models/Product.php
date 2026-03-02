<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'user_id',
    ];

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
