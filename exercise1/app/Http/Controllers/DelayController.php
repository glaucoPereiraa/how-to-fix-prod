<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class DelayController extends Controller
{
    public function handle()
    {
        try {
            $response = Http::get('https://httpbin.org/delay/3');
        } catch (Exception $e) {
            report($e);

            return response()->json(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }


        return response()->json($response->json());
    }
}
