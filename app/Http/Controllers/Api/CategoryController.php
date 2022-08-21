<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Game;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('id', 'desc')->get()->toArray();

        foreach ($categories as $key => &$category) {
            $category['games_count'] = Game::whereHas('league', function ($query) use ($category) {
                return $query->where('category_id', '=', $category['id']);
            })->where('start', '>', date('Y-m-d H:i:s'))->count();

            if ($category['games_count'] == 0) {
                array_splice($categories, $key, 1);
            }
        }

        return $this->successResponse([
            'categories' => $categories
        ], 200);
    }
}
