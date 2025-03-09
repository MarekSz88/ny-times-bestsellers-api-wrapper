<?php

namespace App\Http\Controllers;

use App\Http\Requests\BestSellersSearchRequest;
use App\Services\Interfaces\BestSellers;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class BestSellersController extends Controller
{
    public function __construct(
        private readonly BestSellers $bestSellers
    )
    {
    }

    public function index(BestSellersSearchRequest $request): JsonResponse
    {
        try {
            $request->validated();
            return response()->json($this->bestSellers->search($request));
        } catch (HttpResponseException $exception) {
            return response()->json(['error' => $exception->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
