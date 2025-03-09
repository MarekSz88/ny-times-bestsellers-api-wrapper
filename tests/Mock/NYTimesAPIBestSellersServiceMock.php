<?php

namespace Tests\Mock;

use App\Http\Requests\BestSellersSearchRequest;
use App\Services\NYTimesAPIBestSellersService;
use Illuminate\Support\Facades\Storage;

class NYTimesAPIBestSellersServiceMock extends NYTimesAPIBestSellersService
{
    private const string JSON_SEARCH_RESPONSE_FILE = 'best_sellers_search.json';

    public function search(BestSellersSearchRequest $request): array
    {
        return json_decode(Storage::disk('tests')->get(self::JSON_SEARCH_RESPONSE_FILE), true);
    }
}
