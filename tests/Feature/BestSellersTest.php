<?php

namespace Tests\Feature;

use App\Exceptions\NYTimesAPIException;
use App\Http\Requests\BestSellersSearchRequest;
use App\Services\BestSellersService;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class BestSellersTest extends TestCase
{
    public function test_search_success(): void
    {
        $this->get(route('best-sellers.index'))
            ->assertJsonStructure(['status', 'copyright', 'results', 'num_results']);
    }

    public function test_search_fail_unexpected_param(): void
    {
        $this->get(route('best-sellers.index', ['wrong_param' => 'bang!']))
            ->assertSeeText('The  unexpected field must be true or false.');
    }

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
        $mockService = $this->getMockBuilder(BestSellersService::class)
            ->onlyMethods(['search'])->getMock();
        $mockService->expects($this->once())
            ->method('search')
            ->willThrowException($exception);
        return $mockService;
    }
}
