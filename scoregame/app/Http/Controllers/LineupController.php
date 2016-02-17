<?php

namespace App\Http\Controllers;

use App\Models\Batter;
use App\Models\Game;
use App\Models\Lineup;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LineupController extends Controller
{
    private $validationMessages;


    private function getLineup(Game $game, $team, $method)
    {
        $lineup = $game->$method();
        if ($lineup == null){
            $lineup = new Lineup();
            $lineup->game()->associate($game);
            $lineup->team()->associate($game->$team);
            $lineup->save();
        }

        return $lineup;
    }


    private function getLineupOrFail(Game $game, $team)
    {
        if ($team != 'home' && $team != 'visitor')
            abort(404);

        $lineup = ($team == 'home')?
            $this->getLineup($game,'teamHome','getLineupHome') :
            $this->getLineup($game,'teamVisitor','getLineupVisitor');

        return $lineup;
    }

    private function getBatters(Lineup $lineup)
    {
        $batters = $lineup->batters;
        if ($batters->count() == 0){
            $team = $lineup->team;
            $players = $team->players;
            if ($players->count() < 9){
                return collect([]);
            }

            $battersArray = [];
            $batterPosition = 1;
            foreach($players as $player){
                $batter = Batter::create([
                    'DefensePosition'=>0,
                    'Number'=>$player->Number,
                    'BatterPosition'=>$batterPosition,
                    'Inning'=>1,
                ]);
                $batter->player()->associate($player);
                $batter->setDefensePosition($player->Position);
                $lineup->batters()->save($batter);
                $battersArray[]=$batter;

                $batterPosition++;
                if ($batterPosition == 10){
                    break;
                }
            }

            $batters = collect($battersArray);
            StatisticController::resetStatistic($lineup->game);
        }

        return $batters->sortBy(function($batter) {
            return $batter->BatterPosition*20 + $batter->Inning;
        });
    }


    private function validateInput($input)
    {
        $validator = validator($input, [
            'BatterPosition'=>'int_array:1,10',
            'Number'=>'int_array:1,99',
            'player'=>'int_array',
            'DefensePosition'=>'int_array:0,14',
        ]);

        if ($validator->fails()){
            $this->validationMessages[] = 'All values should be integer';
            return false;
        }


        $this->validationMessages = [];
        $count = count($input['Number']);
        if ($count<9) {
            $this->validationMessages[] = 'Invalid number of players';
            return false;
        }

        $currentBatter = 0;
        foreach($input['BatterPosition'] as $value){
            $currentBatter++;
            if ($value - $currentBatter + 1 > 1){
                $this->validationMessages[] = "Batter $currentBatter not exist";
                return false;
            }
        }

        if (count(array_unique($input['Number'])) != $count ||
            count(array_unique($input['player'])) != $count ||
            count($input['Inning']) != $count) {
            $this->validationMessages[] = 'Number and Player should be unique';
            return false;
        }

        $defensePositionsFlip = array_flip(Batter::$defensePositions);

        if (!in_array($defensePositionsFlip['P'],$input['DefensePosition'])) {
            $this->validationMessages[] = 'Pitcher not exist';
            return false;
        }

        $positions = [];
        foreach($input['BatterPosition'] as $k => $number){
            $positions[$number] = $input['DefensePosition'][$k];
        }


        if (count(array_unique($positions)) != count($positions)){
            $this->validationMessages[] = 'Defense Position should be unique';
            return false;
        }

        $batterInnings = [];
        foreach($input['BatterPosition'] as $k => $number){
            if (!isset($batterInnings[$number]))
                $batterInnings[$number] = [];
            $batterInnings[$number][] = $input['Inning'][$k];
        }

        foreach($batterInnings as $k => $innings){
            if (count(array_unique($innings)) != count($innings)){
                $this->validationMessages[] = 'Substitutions should be in different innings';
                return false;
            }

            if ($innings[0] != 1){
                $this->validationMessages[] = 'Batter '.$k.' starts to play at '.$innings[0].' inning. Should be at 1st.';
                return false;
            }
        }

        return true;
    }

    private function groupBatters($batters)
    {
        $battersByBatPosition = [];
        foreach($batters as $batter){
            if (!isset($battersByBatPosition[$batter->BatterPosition]))
                $battersByBatPosition[$batter->BatterPosition] = [];

            $battersByBatPosition[$batter->BatterPosition][] = $batter;
        }

        return $battersByBatPosition;
    }

    public function edit($id, $team)
    {
        $game = Game::findOrFail($id);
        $lineup = $this->getLineupOrFail($game, $team);
        $batters = $this->getBatters($lineup);

        if ($batters->count() == 0)
            return view('game.update.lineup',compact(['game','team','lineup','batters']))->withErrors(['Invalid players count']);

        $players = $lineup->team->getPlayerNames();
        $battersByBatPosition = $this->groupBatters($batters);

        return view('game.update.lineup',compact(['game','team','lineup','battersByBatPosition','players']));
    }

    public function store($id, $team, Request $request)
    {
        $game = Game::findOrFail($id);
        $lineup = $this->getLineupOrFail($game, $team);
        $batters = $this->getBatters($lineup);

        $input = $request->all();
        if ($this->validateInput($input)){
            for($i=0; $i < min(count($input['BatterPosition']),$batters->count()); $i++){
                $batters[$i]->update([
                    'BatterPosition'=>$input['BatterPosition'][$i],
                    'DefensePosition'=>$input['DefensePosition'][$i],
                    'Number'=>$input['Number'][$i],
                    'Inning'=>$input['Inning'][$i],
                    'Players_idplayer'=>$input['player'][$i]
                ]);
            }

            for($i=count($input['BatterPosition']); $i < $batters->count(); $i++){
                $batters[$i]->delete();
            }

            for($i=$batters->count(); $i < count($input['BatterPosition']); $i++){
                $batter = Batter::create([
                    'BatterPosition'=>$input['BatterPosition'][$i],
                    'DefensePosition'=>$input['DefensePosition'][$i],
                    'Number'=>$input['Number'][$i],
                    'Inning'=>$input['Inning'][$i],
                    'Players_idplayer'=>$input['player'][$i]
                ]);
                $lineup->batters()->save($batter);
                $batters[]=$batter;
            }

            StatisticController::resetStatistic($game);

            $lineup->valid = 1;
            $lineup->save();

            if (isset($input['redirect']))
                return redirect($input['redirect']);

            return redirect(action('LineupController@edit',
                ['id'=>$game->idgame, 'team'=>($team == 'home')? 'visitor' : 'home']));
        }

        $players = $lineup->team->getPlayerNames();
        $battersByBatPosition = $this->groupBatters($batters);

        return view('game.update.lineup',compact(['game','team','lineup','battersByBatPosition','players']))
            ->withErrors($this->validationMessages);
    }
}
