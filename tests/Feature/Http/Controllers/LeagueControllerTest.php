<?php

namespace Http\Controllers;

use App\Models\League;
use App\Models\LeagueTeam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LeagueControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testShow()
    {
        $league = League::factory()->create();

        $response = $this->get('/leagues/'.$league->id);

        $response->assertStatus(500);
    }

    public function testIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
