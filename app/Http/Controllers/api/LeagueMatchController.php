<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LeagueMatch;
use Illuminate\Http\JsonResponse;

class LeagueMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(LeagueMatch::all());
    }

    /**
     * Display the specified resource.
     *
     * @param LeagueMatch $match
     * @return JsonResponse
     */
    public function show(LeagueMatch $match): JsonResponse
    {
        return response()->json($match);
    }
}
