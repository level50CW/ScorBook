<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScorePadController extends Controller
{
    private function getLineup(Game $game, $team)
    {
        $lineup = ($team == 'home')?
            $game->getLineupHome() :
            $game->getLineupVisitor();

        return $lineup;
    }

    public function index($id, $team)
    {
        $game = Game::findOrFail($id);
        $lineup = $this->getLineup($game, $team);

        if ($lineup == null) {
            $batters = null;
            return view('game.update.scorepad', compact(['game','team','batters']))
                ->withErrors(['Lineup is not created.']);
        }

        $batters = $lineup->batters;
        return view('game.update.scorepad',compact(['game','team','batters']));
    }
}
