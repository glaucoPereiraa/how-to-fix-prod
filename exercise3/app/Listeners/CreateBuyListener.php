<?php

namespace App\Listeners;

use App\Events\BuyReceivedEvent;
use App\Service\BuyService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateBuyListener implements ShouldQueue
{
    public function handle(BuyReceivedEvent $event): void
    {
        app(BuyService::class)->handle($event->buyDto);
    }
}
