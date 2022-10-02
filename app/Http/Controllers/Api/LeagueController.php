<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Models\League;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeagueController extends Controller
{
    public function indexByNameId(Request $request, $nameId)
    {
        $leagues = League::whereHas('category', function ($query) use ($nameId) {
            return $query->where('name_id', '=', $nameId);
        })->with('country')->orderBy('id', 'desc')->get()->toArray();

        foreach ($leagues as $key => &$league) {
            $league['games_count'] = Game::where('league_id', $league['id'])->where('start', '>', date('Y-m-d H:i:s'))->count();

            if ($league['games_count'] == 0) {
                array_splice($leagues, $key, 1);
            }
        }

        return $this->successResponse([
            'leagues' => $leagues
        ], 200);
    }

    public function indexByCategoryId(Request $request, $categoryId)
    {
        $leagues = League::where('category_id', $categoryId)->with('country')->orderBy('id', 'desc')->get()->toArray();

        foreach ($leagues as $key => &$league) {
            $league['games_count'] = Game::where('league_id', $league['id'])->where('start', '>', date('Y-m-d H:i:s'))->count();

            if ($league['games_count'] == 0) {
                array_splice($leagues, $key, 1);
            }
        }

        return $this->successResponse([
            'leagues' => $leagues
        ], 200);
    }
}
