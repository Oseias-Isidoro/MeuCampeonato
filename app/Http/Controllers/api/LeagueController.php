<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Models\League;
use Illuminate\Http\JsonResponse;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $leagues = League::all();

        return response()->json($leagues);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLeagueRequest $request
     * @return JsonResponse
     */
    public function store(StoreLeagueRequest $request): JsonResponse
    {
        $league = League::create($request->validated());

        if (!$league)
            return response()->json(['message' => 'error creating league'], 500);

        return response()->json($league);
    }

    /**
     * Display the specified resource.
     *
     * @param League $league
     * @return JsonResponse
     */
    public function show(League $league): JsonResponse
    {
        return response()->json($league);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeagueRequest $request
     * @param League $league
     * @return JsonResponse
     */
    public function update(UpdateLeagueRequest $request, League $league): JsonResponse
    {
        if (!$league->update($request->validated()))
            return response()->json(['message' => 'error updating league'], 500);

        return response()->json($league);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param League $league
     * @return JsonResponse
     */
    public function destroy(League $league): JsonResponse
    {
        if (!$league->delete())
            return response()->json(['message' => 'error deleting league'], 500);

        return response()->json(['message' => "league $league->id deleted"]);
    }
}
