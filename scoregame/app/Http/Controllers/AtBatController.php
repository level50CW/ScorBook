<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Lineup;
use App\Models\Settings;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AtBatController extends Controller
{
    public function index($id){
        $game = Game::findOrFail($id);

        if (empty($game->temperature) || empty($game->weather)){
            return view('game.update.atbat_',compact(['game', 'lineupPlayers'=>null,'usePitchTracker'=>false]))
                ->withErrors(['Game info is not set']);
        }

        $lineups = [$game->getLineupVisitor(),$game->getLineupHome()];

        $messages = [];
        if ($lineups[0] == null || $lineups[0]->valid == 0)
            $messages[] = 'Visitor Lineup is not saved';
        if ($lineups[1] == null || $lineups[1]->valid == 0)
            $messages[] = 'Home Lineup is not saved';

        if (count($messages)>0)
            return view('game.update.atbat_',compact(['game', 'lineupPlayers'=>null,'usePitchTracker'=>false]))
                ->withErrors($messages);

        if (Lineup::hasDH($lineups[0]->batters) != Lineup::hasDH($lineups[1]->batters)){
            return view('game.update.atbat_',compact(['game', 'lineupPlayers'=>null,'usePitchTracker'=>false]))
                ->withErrors(['Only one lineup has DH player']);
        }

        $lineupPlayers = [];
        foreach($lineups as $lineup){
            if ($lineup == null)
                return view('game.update.atbat_',compact(['game', 'lineupPlayers'=>null,'usePitchTracker'=>false]))
                    ->withErrors(['Lineup is not created']);

            $batters = $lineup->batters()->get()->sortBy(function($batter){
                return $batter->BatterPosition*100+$batter->SubOrder;
            });
            $dh = Lineup::hasDH($batters);
            $players =[
                'name'=>$lineup->team->Name,
                'lineup'=>Lineup::takeHitters($batters,$dh),
                'fielders'=>Lineup::takeFielders($batters,$dh),
                'pitchers'=> Lineup::takePitchers($batters)
            ];

            $lineupPlayers[]=$players;
        }

        $lineupPlayers[0]['oppositePitchers'] = $lineupPlayers[1]['pitchers'];
        $lineupPlayers[1]['oppositePitchers'] = $lineupPlayers[0]['pitchers'];

        $usePitchTracker = Settings::get()->usePitchTracker == 1;

        return view('game.update.atbat_',compact(['game','lineupPlayers','usePitchTracker']));
    }
}