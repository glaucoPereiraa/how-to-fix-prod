<?php

namespace App\Events;

use App\Dto\BuyDto;
use Illuminate\Broadcasting\InteractsWithSockets;;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuyReceivedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public BuyDto $buyDto) {}
}
