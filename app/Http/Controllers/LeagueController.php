<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::orderBy('id', 'DESC')->paginate(10);

        return view('leagues.index', compact('leagues'));
    }

    public function show(League $league) {
        return view('leagues.show', compact('league'));
    }
}
