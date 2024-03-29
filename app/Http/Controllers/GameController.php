<?php

namespace App\Http\Controllers;

use App\Game;
use App\Rank;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Game::all();
    }

    public function indexForTeam()
    {
        return Game::all()->where('places', '>', 1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = new Game;
        $game->name = $request->name;
        $game->description = $request->description;
        $game->places = $request->places;
        $game->save();

        return $game;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return $game;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $game->name = $request->name;
        $game->description = $request->description;
        $game->places = $request->places;
        $game->save();

        return $game;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        if ($game->delete()) {
            return response()->json([
                'message' => 'Success',
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Error',
            ], 500);
        }
    }

    public function players(Game $game)
    {
        return $game->players;
    }

    public function teams(Game $game)
    {
        return $game->teams;
    }

    public function ranks(Game $game) {
        return $game->ranks;
    }

    public function showRank(Game $game, Rank $rank)
    {
        return $rank;
    }

    public function addRank(Request $request, Game $game)
    {
        $rank = Rank::create([
            'name' => $request->name,
            'image' => $request->image,
            'game_id' => $game->id,
        ]);

        return $rank;
    }

    public function updateRank(Request $request, Game $game, Rank $rank)
    {
        $rank->name = $request->name;
        $rank->image = $request->image;
        $rank->save();

        return $rank;
    }

    public function deleteRank(Request $request, Game $game, Rank $rank)
    {
        $rank->delete();

        return response()->json([
            'message' => 'Success',
        ]);
    }

    public function playersPercentage()
    {
        $games = Game::all();

        $countGames = count($games);
        $labels = [];
        $values = [];

        foreach ($games as $game) {
            array_push($labels, $game->name);
            array_push($values, (count($game->players) / $countGames) * 100);
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
