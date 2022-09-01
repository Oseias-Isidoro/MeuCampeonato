<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Services\GameService;
use Exception;

class GameController extends Controller
{
    /**
     * @throws Exception
     */
    public function simulate(League $league): \Illuminate\Http\JsonResponse
    {
        try {
            $service = new GameService($league);
            return response()->json($service->simulate());
        } catch (\Throwable $th) {
            return response()->json(
                ['message' => $th->getMessage()],
                $th->getCode()
            );
        }
    }
}
