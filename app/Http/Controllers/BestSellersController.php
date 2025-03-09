<?php

namespace App\Http\Controllers;

use App\Http\Requests\BestSellersSearchRequest;
use App\Services\Interfaces\BestSellers;
use Illuminate\Http\JsonResponse;

class BestSellersController extends Controller
{
    public function __construct(
        private readonly BestSellers $bestSellers
    )
    {
    }

    public function index(BestSellersSearchRequest $request): JsonResponse
    {
        return response()->json($this->bestSellers->search($request));
    }
}
