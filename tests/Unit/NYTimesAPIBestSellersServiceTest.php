<?php

namespace Tests\Unit;

use App\Exceptions\NYTimesAPIException;
use App\Http\Requests\BestSellersSearchRequest;
use App\Services\NYTimesAPIBestSellersService;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class NYTimesAPIBestSellersServiceTest extends TestCase
{
    public function test_search_connection_exception(): void
    {
        $mockService = $this->prepareMockForException(new Exception());

        $this->expectException(Exception::class);

        $mockService->search(new BestSellersSearchRequest());
    }

    public function test_search_ny_times_api_exception(): void
    {
        $mockService = $this->prepareMockForException(
            new NYTimesAPIException(
                'API error',
                500,
                ['fault' => ['faultstring' => 'Missing credentials']]
            )
        );

        $this->expectException(NYTimesAPIException::class);

        $mockService->search(new BestSellersSearchRequest());
    }

    private function prepareMockForException(Exception|NYTimesAPIException $exception): MockObject
    {
        $mockService = $this->getMockBuilder(NYTimesAPIBestSellersService::class)
            ->onlyMethods(['search'])->getMock();
        $mockService->expects($this->once())
            ->method('search')
            ->willThrowException($exception);
        return $mockService;
    }
}
