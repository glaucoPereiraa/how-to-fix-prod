<?php

namespace App\Http\Controllers;

use App\Dto\BuyDto;
use App\Events\BuyReceivedEvent;
use App\Http\Requests\StoreBuyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BuyController extends Controller
{
    public function store(StoreBuyRequest $request): JsonResponse
    {
        $request->validated();

        $buyDto = new BuyDto(
            $request->get('product_id'),
            $request->get('quantity')
        );

        event(new BuyReceivedEvent($buyDto));

        return response()->json()->setStatusCode(Response::HTTP_CREATED);
    }
}
