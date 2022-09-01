<?php

namespace Http\Controllers\api;

use App\Models\League;
use App\Models\LeagueTeam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LeagueTeamControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testStore()
    {
        $league = League::factory()->create();

        $response = $this->post("api/league/$league->id/teams", [
            'name' => fake()->name
        ]);

        $response->assertStatus(200);


        $model = json_decode($response->content(), true);

        $this->assertDatabaseHas(LeagueTeam::class, [
            'id' => $model['id'],
            'name' => $model['name'],
            'slug' =>  $model['slug']
        ]);
    }

    public function testShow()
    {
        $team = LeagueTeam::factory()->create();

        $response = $this->get('/api/teams/'.$team->id);

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $team = LeagueTeam::factory()->create(['league_id' => League::factory()->create()->id]);

        $data = [
            'name' => 'teste name'
        ];

        $response = $this->put('/api/teams/'.$team->id, $data);

        $this->assertDatabaseHas(LeagueTeam::class, [
            'id' => $team->id,
            'name' => $data['name'],
        ]);

        $response->assertStatus(200);
    }

    public function testIndex()
    {
        $response = $this->get('/api/teams');
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $team = LeagueTeam::factory()->create();

        $response = $this->delete('/api/teams/'.$team->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing(LeagueTeam::class, [
            'id' => $team->id,
            'name' => $team->name,
            'slug' =>  $team->slug,
            'deleted' => null
        ]);
    }
}
