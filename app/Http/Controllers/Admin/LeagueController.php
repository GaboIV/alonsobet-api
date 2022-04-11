<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\Team;
use App\Models\League;
use App\Models\BetType;
use App\Models\Category;
use App\Models\Competitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\League\LeagueRequest;

class LeagueController extends Controller
{
    public function index(Request $request)
    {
        $leagues = League::filterByColumns($request->all())
            ->orderBy('id', 'desc')->paginate(20);

        return $this->successResponse($leagues, 200);
    }

    public function store(LeagueRequest $request)
    {
        $data = $request->all();

        $league = League::create($data);

        return $this->successResponse($league, 200);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        League::whereId($id)->update($data);

        return $this->successResponse([
            'status' => 'success'
        ], 200);
    }

    public function byCategory(Request $request)
    {
        $data = $request->all();

        $query = League::where('name', '!=', null);

        if (isset($request['category_id']) && $request['category_id'] != 0) {
            $query->whereCategoryId($request['category_id']);
        }

        if (isset($request['country_id']) && $request['country_id'] != 0) {
            $query->whereCountryId($request['country_id']);
        }

        $leagues = $query->get();

        return $this->successResponse([
            'ligas' => $leagues
        ], 200);
    }

    public function destroy($id)
    {
    }

    public function sync($id)
    {
        $league = League::whereId($id)->first();

        if ($league->name_uk) {
            foreach ($league->name_uk as $key => $sync_id) {
                // $client = new \GuzzleHttp\Client(['verify' => false, 'headers' => [
                //     'Content-Type' => 'text/plain'
                // ]]);

                $url = 'https://sports.tipico.de/json/program/selectedEvents/all/' . $sync_id . "/?apiVersion=1";

                $response = Http::withOptions([
                    'verify' => false,
                ])->get($url);

                $data = $response->json()['SELECTION'];

                $key_sport = key($data['availableMarkets']);

                if (isset($data['sports']) && count($data['sports']) > 0 && $key_sport == $data['sports'][0]['sportId']) {

                    $games = $data['events'];

                    $bet_types = $data['availableMarkets'][$key_sport];

                    foreach ($bet_types as $key => $bt) {
                        $importance = 50;

                        $bet_type = BetType::UpdateOrCreate([
                            "name" => $bt,
                            "category_id" => $league->category_id
                        ], [
                            "importance" => $importance
                        ]);

                        $importance--;
                    }

                    foreach ($games as $key => $game) {
                        $teams = [];
                        $teams_id = [];

                        for ($i = 1; isset($game["team" . $i]); $i++) {
                            if ($game["team" . $i . "Id"] == 0) {
                                $teams[$i] = Team::firstOrCreate([
                                    "name_id" => $game["team" . $i]
                                ], [
                                    "web_id" => $game["team" . $i . "Id"],
                                    "name" => $game["team" . $i],
                                    "name_id" => $game["team" . $i]
                                ]);
                            } else {
                                $teams[$i] = Team::firstOrCreate([
                                    "web_id" => $game["team" . $i . "Id"],
                                ], [
                                    "web_id" => $game["team" . $i . "Id"],
                                    "name" => $game["team" . $i],
                                    "name_id" => $game["team" . $i]
                                ]);
                            }

                            $teams_id[] = $teams[$i]->id;

                            $teams[$i]->leagues()->syncWithoutDetaching($league->id);
                        }

                        $match = Game::updateOrCreate([
                            "web_id" => $game['id'],
                            "league_id" => $league->id,
                        ], [
                            "start" => date('Y-m-d H:i:s', ($game['eventStartTime'] / 1000)),
                            "description" => $game['eventInfo'],
                            "teams_id" => (array) $teams_id,
                        ]);

                        if (is_null($match->result)) {
                            foreach ($data['matchOddGroups'][$game['id']] as $key => $option_type) {

                                $bet_type = BetType::whereName($key)->first();

                                $ht = null;

                                if (strpos($bet_type->name, 'section-') !== false) {
                                    if (strpos($key, '1.') !== false) {
                                        $ht = 1;
                                    } elseif (strpos($key, '2.') !== false) {
                                        $ht = 2;
                                    } else {
                                        $ht = null;
                                    }
                                } else {
                                    $ht = null;
                                }

                                foreach ($option_type as $key => $option) {
                                    Competitor::updateOrCreate([
                                        "game_id" => $match->id,
                                        "code" => $option['fixedParamText'],
                                        "bet_type_id" => $bet_type->id,
                                        "HT" => $ht
                                    ], [
                                        "data" => $option['results'],
                                        "provider" => "tipico"
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $this->successResponse(true, 200);
    }

    public function syncLeagues48()
    {
        $client = new \GuzzleHttp\Client(['verify' => false, 'headers' => [
            'Content-Type' => 'text/plain'
        ]]);

        $url = 'https://sports.tipico.de/json/program/navigationTree/48hrs';

        $data = json_decode($client->request('GET', $url)->getBody());

        foreach ($data->children as $key => $category) {
            $category_ids[] = $category->icon;

            $category_db = Category::whereNameId($category->icon)->first();

            if ($category)
                $categories[] = $category_db;

            foreach ($category->children as $key => $country) {
                foreach ($country->children as $key => $league) {
                    $leagues[] = (int) $league->groupId;
                }
            }

            $query_league = League::orderBy('name');

            foreach ($leagues as $league_item) {
                // $query_league->orWhereRaw("JSON_CONTAINS(name_uk, ?)", $league_item);

                $query_league->orWhere('name_uk', 'like', '%' . $league_item . '%');
            }

            $leagues_db = $query_league->get();

            foreach ($leagues_db as $key => $league_job) {
                $job_league = new SyncLeagueJob($league_job);
                dispatch($job_league);
            }

            $leagues_db = [];
            $leagues = [];
        }

        return $this->successResponse($leagues_db ?? [], 200);
    }

    public function attachNameUk(Request $request, $id)
    {
        $data = $request->all();

        $league = League::whereId($id)->first();

        if (isset($league->name_uk)) {
            if (!in_array($data['code'], $league->name_uk)) {
                $arrays_name_uk = array_merge($league->name_uk, [$data['code']]);

                $league->update([
                    "name_uk" => $arrays_name_uk
                ]);
            }
        } else {
            $league->update([
                "name_uk" => [$data['code']]
            ]);
        }

        return $this->successResponse([
            'league' => $league->fresh()
        ], 200);
    }

    public function dettachNameUk(Request $request, $id)
    {
        $data = $request->all();

        $league = League::whereId($id)->first();

        if (in_array($data['code'], $league->name_uk)) {
            $arr = array_filter($league->name_uk, function ($v) use ($data) {
                return $v != $data['code'];
            });

            $league->update([
                "name_uk" => array_values($arr)
            ]);
        }

        return $this->successResponse([
            'league' => $league->fresh()
        ], 200);
    }
}
