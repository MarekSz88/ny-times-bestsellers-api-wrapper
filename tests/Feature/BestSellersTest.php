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
        $request = new BestSellersSearchRequest();

        $this->get(route('best-sellers.index'), $request->toArray())
            ->assertJsonStructure(['status', 'copyright', 'results', 'num_results']);
    }

    public function test_search_connection_exception(): void
    {
        $handler = $this->prepareMockForException(new Exception());

        $this->expectException(Exception::class);

        $handler->search(new BestSellersSearchRequest());
    }

    public function test_search_ny_times_api_exception(): void
    {
        $handler = $this->prepareMockForException(
            new NYTimesAPIException(
                'API error',
                500,
                ['fault' => ['faultstring' => 'Missing credentials']]
            )
        );

        $this->expectException(NYTimesAPIException::class);

        $handler->search(new BestSellersSearchRequest());
    }

    private function prepareMockForException(Exception|NYTimesAPIException $exception): MockObject
    {
        $handler = $this->getMockBuilder(BestSellersService::class)
            ->onlyMethods(['search'])->getMock();
        $handler->expects($this->once())
            ->method('search')
            ->willThrowException($exception);
        return $handler;
    }
}
