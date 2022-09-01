<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueTeamRequest;
use App\Http\Requests\UpdateLeagueTeamRequest;
use App\Models\League;
use App\Models\LeagueTeam;
use Illuminate\Http\JsonResponse;

class LeagueTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(LeagueTeam::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLeagueTeamRequest $request
     * @param League $league
     * @return JsonResponse
     */
    public function store(StoreLeagueTeamRequest $request, League $league): JsonResponse
    {
        if ($league->teams()->count() >= League::TEAMS_MAX)
            return response()->json(['message' => 'um campeonato não pode ter mais de 8 times'], 400);

        $team = $league->teams()->create($request->validated());

        if (!$team)
            return response()->json(['message' => 'error creating team'], 500);

        return response()->json($team);
    }

    /**
     * Display the specified resource.
     *
     * @param LeagueTeam $team
     * @return JsonResponse
     */
    public function show(LeagueTeam $team): JsonResponse
    {
        return response()->json($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeagueTeamRequest $request
     * @param LeagueTeam $team
     * @return JsonResponse
     */
    public function update(UpdateLeagueTeamRequest $request, LeagueTeam $team): JsonResponse
    {
        if (!$team->update($request->validated()))
            return response()->json(['message' => 'error updating team'], 500);

        return response()->json($team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LeagueTeam $team
     * @return JsonResponse
     */
    public function destroy(LeagueTeam $team): JsonResponse
    {
        if (!$team->delete())
            return response()->json(['message' => 'error deleting team'], 500);

        return response()->json(['message' => "league $team->id deleted"]);
    }
}
