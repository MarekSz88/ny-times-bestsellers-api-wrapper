<?php

namespace App\Services\Interfaces;

use App\Http\Requests\BestSellersSearchRequest;

interface BestSellers
{
    public function search(BestSellersSearchRequest $request): array;
}
