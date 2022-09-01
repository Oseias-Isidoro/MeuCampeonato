<?php

namespace Http\Controllers\api;

use App\Models\League;
use App\Models\LeagueMatch;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LeagueMatchControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testShow()
    {
        $matche = LeagueMatch::factory()->create();

        $response = $this->get('/api/matches/'.$matche->id);

        $response->assertStatus(200);
    }

    public function testIndex()
    {
        $response = $this->get('/api/matches');
        $response->assertStatus(200);
    }
}
