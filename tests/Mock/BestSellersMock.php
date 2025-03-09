<?php

namespace Tests\Mock;

use App\Http\Requests\BestSellersSearchRequest;
use App\Services\BestSellersService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BestSellersMock extends BestSellersService
{
    private const string JSON_SEARCH_RESPONSE_FILE = 'best_sellers_search.json';

    public function search(BestSellersSearchRequest $request): array
    {
        return json_decode(Storage::disk('tests')->get(self::JSON_SEARCH_RESPONSE_FILE), true);
    }
}
