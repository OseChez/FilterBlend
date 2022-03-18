<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\City;

class CityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testCitiesIndex()
    {
        $city = 'en';
        $this->json('GET',"/api/cities/?q={$city}")
             ->assertOk();
    }
}
