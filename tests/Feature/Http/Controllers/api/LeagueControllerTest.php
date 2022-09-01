<?php

namespace Http\Controllers\api;

use App\Models\League;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LeagueControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $response = $this->get('/api/leagues');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->post('/api/leagues', [
            'name' => fake()->name,
        ]);

        $model = json_decode($response->content(), true);

        $this->assertDatabaseHas(League::class, [
            'id' => $model['id'],
            'name' => $model['name'],
            'slug' =>  $model['slug']
        ]);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $league = League::factory()->create();

        $response = $this->delete('/api/leagues/'.$league->id);

        $this->assertDatabaseMissing(League::class, [
            'id' => $league->id,
            'name' => $league->name,
            'slug' =>  $league->slug,
            'deleted' => null
        ]);

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $league = League::factory()->create();

        $response = $this->get('/api/leagues/'.$league->id);

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $league = League::factory()->create();

        $data = [
          'name' => 'teste name'
        ];

        $response = $this->put('/api/leagues/'.$league->id, $data);

        $this->assertDatabaseHas(League::class, [
            'id' => $league->id,
            'name' => $data['name'],
        ]);

        $response->assertStatus(200);
    }
}
