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
        if ($lineup == null) {
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

        $lineup = ($team == 'home') ?
            $this->getLineup($game, 'teamHome', 'getLineupHome') :
            $this->getLineup($game, 'teamVisitor', 'getLineupVisitor');

        return $lineup;
    }

    private function getBatters(Lineup $lineup)
    {
        $batters = $lineup->batters;
        if ($batters->count() == 0) {
            $team = $lineup->team;
            $players = $team->players;
            if ($players->count() < 9) {
                return collect([]);
            }

            $battersArray = [];
            $batterPosition = 1;
            foreach ($players as $player) {
                $batter = Batter::create([
                    'DefensePosition' => 0,
                    'Number' => $player->Number,
                    'BatterPosition' => $batterPosition,
                    'Inning' => 8,
                ]);
                $batter->player()->associate($player);
                $batter->setDefensePosition($player->Position);
                $lineup->batters()->save($batter);
                $battersArray[] = $batter;

                $batterPosition++;
                if ($batterPosition == 10) {
                    break;
                }
            }

            $batters = collect($battersArray);
            StatisticController::resetStatistic($lineup->game);
        }

        return $batters->sortBy(function ($batter) {
            return $batter->BatterPosition * 20 + $batter->Inning;
        });
    }


    private function validateInput($input)
    {
        $validator = validator($input, [
            'BatterPosition' => 'int_array:1,10',
            'Number' => 'int_array:1,99',
            'player' => 'int_array',
            'DefensePosition' => 'int_array:0,14',
        ]);

        if ($validator->fails()) {
            $this->validationMessages[] = 'All values should be fulfilled in right way';
            return false;
        }


        $this->validationMessages = [];
        $count = count($input['Number']);
        if ($count < 9) {
            $this->validationMessages[] = 'Invalid number of players';
            return false;
        }

        $currentBatter = 0;
        foreach ($input['BatterPosition'] as $value) {
            $currentBatter++;
            if ($value - $currentBatter + 1 > 1) {
                $this->validationMessages[] = "Batter $currentBatter not exist";
                return false;
            }
        }

        if (count(array_unique($input['Number'])) != $count ||
            count(array_unique($input['player'])) != $count ||
            count($input['Inning']) != $count
        ) {
            $this->validationMessages[] = 'Number and Player should be unique';
            return false;
        }

        for ($p = 0; $p < count($input['Inning']); $p++) {
            if (!$this->isInningNumberValid($input['Inning'][$p])) {
                $this->validationMessages[] = 'Inning has invalid value';
                return false;
            }
        }

        for ($p = 1; $p < count($input['Inning']); $p++) {
            if ($input['BatterPosition'][$p-1] == $input['BatterPosition'][$p] &&
                $this->convertInningNumber($input['Inning'][$p-1]) > $this->convertInningNumber($input['Inning'][$p])) {
                $this->validationMessages[] = 'Inning of substitution can not be lower then previous inning';
                return false;
            }
        }


        $requiredPositions = [
            'P' => 'Pitcher',
            'C' => 'Catcher',
            '1B' => 'Player on the 1B',
            '2B' => 'Player on the 2B',
            '3B' => 'Player on the 3B',
            'SS' => 'Short Stop',
            'LF' => 'Left Fielder',
            'CF' => 'Center Fielder',
            'RF' => 'Right Fielder',
            'DH' => 'Designated hitter',
        ];

        for ($i = 1; $i <= max($input['Inning']); $i++) {
            $bufferInningBatterPosition = [];
            $bufferBatterMaxInning = [];

            $isError = false;
            $isDHExist = false;

            for ($p = 0; $p < count($input['player']); $p++) {

                $batterBatter = $input['BatterPosition'][$p];
                $batterDefense = Batter::$defensePositions[$input['DefensePosition'][$p]];
                $batterInning = $this->convertInningNumber($input['Inning'][$p]) >> 3;
                $batterInningOuts = $this->convertInningNumber($input['Inning'][$p]) & 7;

                if ($batterInningOuts>0 && $batterDefense != 'P'){
                    $this->validationMessages[] = 'Only pitcher can have partial innings';
                    $isError = true;
                }

                if (    $batterInning <= $i &&
                        $batterInningOuts == 0 &&
                        (   !isset($bufferBatterMaxInning[$batterBatter]) ||
                            $bufferBatterMaxInning[$batterBatter] <= $batterInning)){

                    if (isset($requiredPositions[$batterDefense])) {
                        $bufferInningBatterPosition[$batterBatter] = $batterDefense;
                        $bufferBatterMaxInning[$batterBatter] = $batterInning;
                        $isDHExist = $isDHExist || $batterDefense == 'DH';
                    }
                }
            }

            $foundPositions = [
                'P' => 0,
                'C' => 0,
                '1B' => 0,
                '2B' => 0,
                '3B' => 0,
                'SS' => 0,
                'LF' => 0,
                'CF' => 0,
                'RF' => 0,
                'DH' => 0
            ];

            foreach ($bufferInningBatterPosition as $batterBatter => $batterDefense) {
                $foundPositions[$batterDefense]++;
            }

            foreach ($foundPositions as $batterDefense => $count) {
                if ($count == 0 && ($isDHExist && $batterDefense == 'DH' || $batterDefense != 'DH')) {
                    $this->validationMessages[] = $requiredPositions[$batterDefense] . ' does not exist in ' . $i . ' inning';
                    $isError = true;
                }

                if ($count > 1) {
                    $this->validationMessages[] = $requiredPositions[$batterDefense] . ' is duplicated in ' . $i . ' inning';
                    $isError = true;
                }
            }

            if ($isError)
                return false;
        }

        return true;
    }

    private function validateInputByGame($input, $game)
    {
        for ($p = 0; $p < count($input['UserChange']); $p++) {
            if ($input['UserChange'][$p] == 1 &&
                $this->convertInningNumber($input['Inning'][$p])>>3 <= $game->last_inning) {
                $this->validationMessages[] = 'Inning of substitution can not be lower then current inning';
                return false;
            }
        }

        return true;
    }

    private function groupBatters($batters)
    {
        $battersByBatPosition = [];
        $sorted = $batters->sortBy(function ($b) {
            return $b->BatterPosition * 1000 + $b->SubOrder;
        });
        foreach ($sorted as $batter) {
            if (!isset($battersByBatPosition[$batter->BatterPosition]))
                $battersByBatPosition[$batter->BatterPosition] = [];

            $battersByBatPosition[$batter->BatterPosition][] = $batter;
        }

        return $battersByBatPosition;
    }

    private function isInningNumberValid($inning)
    {
        $arr = explode('.', $inning);
        $inningNumber = $arr[0] + 0;
        $inningOuts = isset($arr[1]) ? $arr[1] + 0 : 0;

        return $inningNumber>0 && $inningOuts<=2;
    }

    private function convertInningNumber($inning)
    {
        $arr = explode('.', $inning);
        $inningNumber = $arr[0] + 0;
        $inningOuts = isset($arr[1]) ? $arr[1] + 0 : 0;
        return ($inningNumber<<3)+$inningOuts;
    }

    public function edit($id, $team)
    {
        $game = Game::findOrFail($id);
        $lineup = $this->getLineupOrFail($game, $team);
        $batters = $this->getBatters($lineup);

        if ($batters->count() == 0)
            return view('game.update.lineup', compact(['game', 'team', 'lineup', 'batters']))->withErrors(['Invalid players count']);

        $players = $lineup->team->getPlayerNames();
        $playersRemain = [];

        foreach($batters as $batter){
            if (($batter->Inning >> 3) <= $game->last_inning){
                $playersRemain[$batter->player->idplayer] = $players[$batter->player->idplayer];
            }
        }

        $playersRemain = collect($players)->diff($playersRemain)->all();

        $numbers = $lineup->team->getPlayerNumbers();
        $battersByBatPosition = $this->groupBatters($batters);

        return view('game.update.lineup', compact(['game', 'team', 'lineup', 'battersByBatPosition', 'players','playersRemain','numbers']));
    }

    public function store($id, $team, Request $request)
    {
        $game = Game::findOrFail($id);
        $lineup = $this->getLineupOrFail($game, $team);
        $batters = $this->getBatters($lineup);

        $input = $request->all();
        if ($this->validateInput($input) &&
            $this->validateInputByGame($input, $game)) {

            $batterSubOrder = [];
            $batterSubOrderCounter = [];
            for ($i = 0; $i < count($input['BatterPosition']); $i++) {
                $position = $input['BatterPosition'][$i];
                if (!isset($batterSubOrderCounter[$position]))
                    $batterSubOrderCounter[$position] = 0;
                $batterSubOrder[$i] = $batterSubOrderCounter[$position];
                $batterSubOrderCounter[$position]++;
            }


            for ($i = 0; $i < min(count($input['BatterPosition']), $batters->count()); $i++) {
                $batters[$i]->update([
                    'BatterPosition' => $input['BatterPosition'][$i],
                    'DefensePosition' => $input['DefensePosition'][$i],
                    'Number' => $input['Number'][$i],
                    'Inning' => $this->convertInningNumber($input['Inning'][$i]),
                    'Players_idplayer' => $input['player'][$i],
                    'SubOrder' => $batterSubOrder[$i]
                ]);
            }

            for ($i = count($input['BatterPosition']); $i < $batters->count(); $i++) {
                $batters[$i]->delete();
            }

            for ($i = $batters->count(); $i < count($input['BatterPosition']); $i++) {
                $batter = Batter::create([
                    'BatterPosition' => $input['BatterPosition'][$i],
                    'DefensePosition' => $input['DefensePosition'][$i],
                    'Number' => $input['Number'][$i],
                    'Inning' => $this->convertInningNumber($input['Inning'][$i]),
                    'Players_idplayer' => $input['player'][$i],
                    'SubOrder' => $batterSubOrder[$i]
                ]);
                $lineup->batters()->save($batter);
                $batters[] = $batter;
            }

            StatisticController::resetStatistic($game);

            $lineup->valid = 1;
            $lineup->save();

            if (isset($input['redirect']))
                return redirect($input['redirect']);

            return redirect(action('LineupController@edit',
                ['id' => $game->idgame, 'team' => ($team == 'home') ? 'visitor' : 'home']));
        }

        $players = $lineup->team->getPlayerNames();
        $playersRemain = [];

        foreach($batters as $batter){
            if (($batter->Inning >> 3) <= $game->last_inning){
                $playersRemain[$batter->player->idplayer] = $players[$batter->player->idplayer];
            }
        }

        $playersRemain = collect($players)->diff($playersRemain)->all();

        $numbers = $lineup->team->getPlayerNumbers();
        $battersByBatPosition = $this->groupBatters($batters);

        return view('game.update.lineup', compact(['game', 'team', 'lineup', 'battersByBatPosition', 'players', 'playersRemain', 'numbers']))
            ->withErrors($this->validationMessages);
    }
}
