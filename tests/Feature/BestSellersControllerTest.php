<?php

namespace Tests\Feature;

use Tests\TestCase;

class BestSellersControllerTest extends TestCase
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
}
