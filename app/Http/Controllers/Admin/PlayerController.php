<?php

namespace App\Http\Controllers\Admin;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $players = Player::filterByColumns($request->all())->orderBy('created_at', 'desc')->paginate();

        return $this->successResponse($players, 200);
    }

    public function show($id)
    {
        $player = Player::whereId($id)->first();

        return $this->successResponse([
            'player' => $player
        ], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }
}
