<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\LazyCollection;

class BuyProd extends Command
{
    protected $signature = 'app:buy-prod';

    protected $description = 'Command description';

    public function handle()
    {
        $productId = Product::factory()->create([
            'user_id' => User::factory()->create()->id,
        ])->id;

        $stock = Stock::factory()->create([
            'product_id' => $productId,
            'quantity' => 10000,
        ]);

        $quantity = 0;

        LazyCollection::range(1, 1000)->each(function ($count) use ($productId, &$quantity) {
            $quantityBuy = fake()->randomNumber(1, 10);

            $quantity += $quantityBuy;

            Http::post('http://exercise/api/buy', [
                'product_id' => $productId,
                'quantity' => $quantityBuy,
            ]);
        });

        $this->comment('Quantity purchased:' . $quantity);
        $this->comment('Stock id: ' . $stock->id);
    }
}
