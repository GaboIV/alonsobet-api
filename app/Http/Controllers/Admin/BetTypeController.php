<?php

namespace App\Http\Controllers\Admin;

use App\Models\BetType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BetTypeController extends Controller
{
    public function index(Request $request)
    {
        if (request()->page) {
            $bet_types = BetType::filterByColumns($request->all())
            ->with('category')->orderBy('id', 'desc')->paginate(20);
        } else {
            $bet_types = BetType::with('category')->filterByColumns($request->all())->get();
        }

        return $this->successResponse([
            'bet_types' => $bet_types
        ], 200);
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        BetType::whereId($id)->update($data);

        return $this->successResponse([
            'status' => 'success'
        ], 200);
    }
}
