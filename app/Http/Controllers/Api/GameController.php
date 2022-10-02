<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function indexByLeagueId(Request $request, $leagueId)
    {
        $games = Game::where('league_id', $leagueId)->where('start', '>', date('Y-m-d H:i:s'))->get();

        return $this->successResponse([
            'games' => $games
        ], 200);
    }
}
