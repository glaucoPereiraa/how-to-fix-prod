<?php

namespace App\Service;

use App\Dto\BuyDto;
use App\Models\Product;
use App\Models\Transaction;
use App\TransactionTypeEnum;

class BuyService
{
    public function handle(BuyDto $buyDto): void
    {
        $product = Product::find($buyDto->productId);

        $user = $product->user;

        $stock = $product->stock;

        $stock->quantity -= $buyDto->quantity;

        $user->balance += $product->price * $buyDto->quantity;

        Transaction::create([
            'amount' => $product->price * $buyDto->quantity,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => TransactionTypeEnum::CREDIT
        ]);

        $user->save();
        $stock->save();
    }
}