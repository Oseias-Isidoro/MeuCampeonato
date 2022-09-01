<?php

namespace App\Services;

use App\Models\League;
use Exception;
use Illuminate\Support\Collection;

class GameService
{
    private League $league;
    private Collection $teams;
    private array $phase_data = [
        'quarterfinals' => 4,
        'semifinals' => 2,
        'third_place' => 1,
        'final' => 1
    ];

    public function __construct($league)
    {
        $this->league = $league;
        $this->teams = $league->teams()->get();
    }

    /**
     * @throws Exception
     */
    public function simulate(): array
    {
        if ($this->league->isFinished())
            throw new \Exception('Este campeonato já foi simulado', 400);

        if ($this->league->teams()->count() !== League::TEAMS_MAX)
            throw new \Exception('Para simular o campeonato ele deve ter exatos 8 times', 400);

        $quarterfinalResult = $this->simulateQuarterfinalAndSemifinalMatches($this->teams, 'quarterfinals');
        $semifinalsResult = $this->simulateQuarterfinalAndSemifinalMatches(new Collection($quarterfinalResult['winners']), 'semifinals');
        $thirdPlaceResult = $this->simulateThirdPlaceMatches(new Collection($semifinalsResult['losers']));
        $finalResult = $this->simulateFinalMatch(new Collection($semifinalsResult['winners']));

        // muda status do campeonato de 'pending' para 'finished'
        $this->league->finish();

        return [
            'league' => $this->league,
            'quarter' => $quarterfinalResult,
            'semifinals' => $semifinalsResult,
            'third_place' => $thirdPlaceResult,
            'final' => $finalResult,
        ];
    }

    /**
     * @throws Exception
     */
    private function simulateQuarterfinalAndSemifinalMatches($teams, $phase): array
    {
        $result = $this->simulateMatches(
            $teams instanceof Collection ? $teams : new Collection($teams),
            $phase
        );

        foreach ($result['losers'] as $loser)
            $loser->markAsEliminated();

        return $result;
    }

    /**
     * @throws Exception
     */
    private function simulateFinalMatch($teams): array
    {
        $result = $this->simulateMatches(new Collection($teams), 'final');

        // Muda o status do time conforme o resultado da partida
        $result['losers'][0]->markAsSecond();
        $result['winners'][0]->markAsChampion();

        return $result;
    }

    /**
     * @throws Exception
     */
    private function simulateThirdPlaceMatches($teams): array
    {
        $result = $this->simulateMatches(new Collection($teams), 'third_place');

        // Muda o status do time conforme o resultado da partida
        $result['losers'][0]->markAsEliminated();
        $result['winners'][0]->markAsThird();

        return $result;
    }

    /**
     * @throws Exception
     */
    private function simulateMatches($teams, $phase): array
    {
        $matches = $this->createMatches($teams, $phase);

        $return = [
            'winners' => [],
            'losers' => []
        ];

        foreach ($matches as $match)
        {
            $goals = $this->getScoreWithPython();

            // Esse while representa as cobranças de pênaltis, o loop continuara até que o empate seja resolvido
            while ($this->isTied($goals)) {
                $this->penaltyKicks($goals);
            }

            // salva dados como vencedor e gols
            $match->winning_team_id = $goals['team_home'] > $goals['team_outside'] ? $match->team_home_id : $match->team_outside_id;
            $match->team_home_goals = $goals['team_home'];
            $match->team_outside_goals = $goals['team_outside'];
            $match->save();

            // atualiza as dados so time da casa
            $match->getTeamHome->phase = $phase;
            $match->getTeamHome->goals += $goals['team_home'];
            $match->getTeamHome->goals_taken += $goals['team_outside'];
            $match->getTeamHome->save();

            // atualiza as dados so time que esta jogando fora de casa
            $match->getTeamOutside->phase = $phase;
            $match->getTeamOutside->goals += $goals['team_outside'];
            $match->getTeamOutside->goals_taken += $goals['team_home'];
            $match->getTeamOutside->save();


            $return['winners'][] = $goals['team_home'] > $goals['team_outside'] ? $match->getTeamHome : $match->getTeamOutside;
            $return['losers'][] = $goals['team_home'] < $goals['team_outside'] ? $match->getTeamHome : $match->getTeamOutside;
        }

        return $return;
    }

    private function isTied($team_goals): bool
    {
        return $team_goals['team_home'] === $team_goals['team_outside'];
    }

    private function createMatches($teams, $phase): array
    {
        $randomized_teams = $teams->shuffle();
        $groups = $randomized_teams->split($this->phase_data[$phase]);
        $matches = [];

        foreach ($groups as $group) {
            $matches[] = $this->league->matches()
                ->create([
                    'phase' => $phase,
                    'team_home_id' => $group[0]->id,
                    'team_outside_id' => $group[1]->id
                ]);
        }

        return $matches;
    }

    /**
     * @throws Exception
     */
    private function penaltyKicks(&$goals): void
    {
        $penaltyGoals = $this->getScoreWithPython();
        $goals['team_home'] += $penaltyGoals['team_home'];
        $goals['team_outside'] += $penaltyGoals['team_outside'];
    }

    /**
     * @throws Exception
     */
    private function getScoreWithPython()
    {
        $raw_output = exec('python "'. base_path() . '\teste.py"');

        $output = json_decode($raw_output, true);

        if (empty($output))
            throw new Exception("Error executing python code", 500);

        return $output;
    }


    /**
     *  Caso não tenha python em sua máquina, use o método abaixo no lugar de 'getScoreWithPython'
     */
//    public function getScore()
//    {
//        return [
//            'team_home' => rand(0, 8),
//            'team_outside' => rand(0, 8),
//        ];
//    }
}
