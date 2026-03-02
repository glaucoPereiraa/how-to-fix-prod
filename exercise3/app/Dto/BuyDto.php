<?php

namespace App\Dto;

class BuyDto
{
    public function __construct(
        readonly public int $productId,
        readonly public int $quantity
    ) {}
}