<?php

namespace App\Services;

use App\Exceptions\NYTimesAPIException;
use App\Http\Requests\BestSellersSearchRequest;
use App\Services\Interfaces\BestSellers;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BestSellersService implements BestSellers
{
    protected const int RESPONSE_CACHE_TTL = 600;
    private const string BESTSELLERS_HISTORY_URL = 'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json';

    public function search(BestSellersSearchRequest $request): array
    {
        try {
            $targetUrl = $this->buildTargetUrl($request);
            return Cache::remember($this->getCacheKey($targetUrl),
                self::RESPONSE_CACHE_TTL,
                function () use ($targetUrl) {
                    return $this->getBestSellersDataFromNYTimesAPI($targetUrl);
                });
        } catch (NYTimesAPIException|Exception $exception) {
            $this->abortNicely($exception);
        }
    }

    private function buildTargetUrl(BestSellersSearchRequest $request): string
    {
        return sprintf("%s?%s&%s",
            self::BESTSELLERS_HISTORY_URL,
            'api-key=' . config('bestseller.new_york_times_books_public_key'),
            http_build_query($request->all())
        );
    }

    private function getCacheKey(string $targetUrl): string
    {
        return md5($targetUrl);
    }

    /**
     * @throws ConnectionException
     */
    private function getBestSellersDataFromNYTimesAPI(string $targetUrl): array
    {
        $response = Http::get($targetUrl);
        $this->verifyResponse($response);
        return $this->handleResponseData($response);
    }

    /**
     * @throws NYTimesAPIException
     */
    private function verifyResponse(Response $response): void
    {
        if ($response->failed()) {
            throw new NYTimesAPIException('Connection with NYTimes API failed', $response->status(), $response->json());
        }
    }

    private function handleResponseData(Response $response): array
    {
        return $response->json();
    }

    private function abortNicely(mixed $exception): void
    {
        abort($exception->getCode(), $exception->getMessage());
    }
}
