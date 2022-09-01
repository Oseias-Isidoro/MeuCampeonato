<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\LeagueTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeagueMatch>
 */
class LeagueMatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $league =  League::factory()->create();

        return [
            'league_id' => $league->id,
            'team_home_id' => LeagueTeam::factory()->create(['league_id' => $league->id])->id,
            'team_outside_id' => LeagueTeam::factory()->create(['league_id' => $league->id])->id,
        ];
    }
}
