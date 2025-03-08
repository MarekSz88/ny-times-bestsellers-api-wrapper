<?php

namespace App\Services;

use App\Exceptions\NYTimesAPIException;
use App\Http\Requests\BestSellersSearchRequest;
use App\Services\Interfaces\BestSellers;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class BestSellersService implements BestSellers
{
    private const string BESTSELLERS_HISTORY_URL = 'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json';

    public function search(BestSellersSearchRequest $request): array
    {
        try {
            $response = $this->getBestSellersDataFromNYTimesAPI($this->buildTargetUrl($request));
            return $response;
        } catch (NYTimesAPIException $exception) {
            $this->abortNicely($exception);
        } catch (\Exception $exception) {
            $this->abortNicely($exception);
        }
    }

    private function buildTargetUrl(BestSellersSearchRequest $request): string
    {
        return sprintf("%s?%s&%s",
            self::BESTSELLERS_HISTORY_URL,
            'api-key=' . config('bestseller.new_york_times_books_public_key'),
            join('&', $request->all())
        );
    }

    /*
     * @throws \ConnectionException
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

    private function handleResponseData(Response $response): void
    {
        dd($response->json());
    }

    private function abortNicely(mixed $exception): void
    {
        abort($exception->getCode(), $exception->getMessage());
    }
}
