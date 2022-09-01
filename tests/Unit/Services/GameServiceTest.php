<?php

namespace Services;

use App\Models\League;
use App\Models\LeagueTeam;
use App\Services\GameService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @throws \Exception
     */
    public function testSimulate()
    {
        $league = League::factory()->create();
        LeagueTeam::factory()->count(League::TEAMS_MAX)->create(['league_id' => $league->id]);

        $result = (new GameService($league))->simulate();

        $this->assertArrayHasKey('final',$result);
        $this->assertArrayHasKey('third_place',$result);
        $this->assertArrayHasKey('semifinals',$result);
        $this->assertArrayHasKey('quarter',$result);
    }
}
