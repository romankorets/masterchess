<?php

namespace App\Http\Controllers;

use App\Game;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $games = Game::all()->where('started', 'false');
        return view('game.index', [
            'games' => $games
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('game.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $firstPlayerColor = $request->get('color');
        $secondPlayerColor = '';
        switch ($firstPlayerColor){
            case 'random':
                $randomColor = rand(0, 1);
                if ($randomColor == 0) {
                    $firstPlayerColor = 'white';
                    $secondPlayerColor = 'black';
                } else {
                    $firstPlayerColor = 'black';
                    $secondPlayerColor = 'white';
                }
                break;
            case 'white':
                $secondPlayerColor = 'black';
                break;
            case 'black':
                $secondPlayerColor = 'white';
                break;
        }

        $game = Game::create([
                'first_player_id' => Auth::user()->id,
                'first_player_color' => $firstPlayerColor,
                'second_player_color' => $secondPlayerColor,
                'moves' => [
                    ['id' => 0,
                    'move' => 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1']
                ]
            ]
        );
        return redirect()->route('game.show', ['game' => $game]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);
        return view('game.show', ['game' => $game]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Return data to update game
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGame($id)
    {
        $game = Game::findOrFail($id);
        return response()->json([
            'firstPlayerId' => $game->first_player_id,
            'secondPlayerId' => $game->second_player_id,
            'moves' => $game->moves,
        ]);
    }

    /**
     * Show current games of user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMyGames()
    {
        $user = User::findOrFail(Auth::user()->id);
          $gamesAsFirstPlayer = Game::all()
              ->where('first_player_id', $user->id)
              ->where('finished', false)
              ->where('started', true);
          $gamesAsSecondPlayer = Game::all()
              ->where('second_player_id', $user->id)
              ->where('finished', false)
              ->where('started', true);
        return view('myGames',
            ['gamesAsFirstPlayer' => $gamesAsFirstPlayer,
             'gamesAsSecondPlayer' => $gamesAsSecondPlayer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->fill($request->all());
        $game->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
