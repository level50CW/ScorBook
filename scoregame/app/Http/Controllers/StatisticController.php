<?php

namespace App\Http\Controllers;

use App\Models\Batter;
use App\Models\Lineup;
use App\Models\Player;
use DB;
use App\Models\_Season;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StatisticController extends Controller
{
    private $statTables = [
        'batting' => 'statshitting',
        'fielding' => 'statsfielding',
        'pitching' => 'statspitching',
    ];

    private function getLineup(Game $game, $team)
    {
        $lineup = ($team == 'home')?
            $game->getLineupHome() :
            $game->getLineupVisitor();

        return $lineup;
    }

    private function getGameStatistic(Lineup $lineup, $table)
    {
        $res = DB::table($table)
            ->join('players','players.idplayer','=',"$table.Players_idplayer")
            ->join('batters','batters.Players_idplayer','=','players.idplayer')
            ->where("$table.Games_idgame",$lineup->game->idgame)
            ->where('batters.Lineup_idlineup',$lineup->idlineup)
            ->select(['batters.Number', 'players.Firstname','players.Lastname',"$table.*"])
            ->get();
        return $res;
    }

    private function getSeasonStatistic(_Season $season, Team $team, $table)
    {
        $select = '`batters`.`Players_idplayer`, `batters`.`Number`, `players`.`Firstname`, `players`.`Lastname`';
        $keys = $this->getKeys($table);
        foreach($keys as $key){
            $select .= ", sum(`$table`.`$key`) as $key";
        }

        $res = DB::table($table)
            ->join('games','games.idgame','=',"$table.Games_idgame")
            ->join('lineup','lineup.Games_idgame','=',"$table.Games_idgame")
            ->join('players','players.idplayer','=',"$table.Players_idplayer")
            ->join('batters',function($join){
                $join->on('batters.Players_idplayer','=','players.idplayer')
                    ->on('batters.Lineup_idlineup','=','lineup.idlineup');
            })
            ->where('games.season_idseason','=',$season->idseason)
            ->where('lineup.Teams_idteam',$team->idteam)
            ->groupBy("$table.Players_idplayer")
            ->selectRaw($select)
            ->get();

        return $res;
    }

    private function getStatistic(Game $game, $team, $period, $type)
    {
        $lineup = $this->getLineup($game,$team);

        if ($lineup == null)
            return null;

        if ($period == 'season')
            return $this->getSeasonStatistic($game->season,$lineup->team,$this->statTables[$type]);
        else
            return $this->getGameStatistic($lineup,$this->statTables[$type]);
    }

    private function getTotals($stats, $keys){
        $totals = [];
        foreach($keys as $key){
            $totals[$key] = 0;
            foreach($stats as $stat){
                $totals[$key] += $stat->$key;
            }
        }
        return $totals;
    }

    private function getKeys($table){
        switch($table)
        {
            case 'statshitting': return ["G", "AB", "R", "H", "v2B", "v3B", "HR", "RBI", "BB", "SO", "SB", "CS", "HBP", "SAC", "PA", "XBH", "AVG", "OBP", "SLG", "OPS"];
            case 'statsfielding': return ["G", "GS", "INN", "TC", "PO", "A", "E", "DP", "SB", "CS", "SBPCT", "PB", "C_WP", "FPCT", "RF"];
            case 'statspitching': return ["W", "L", "ERA", "G", "GS", "SV", "SVO", "IP", "H", "R", "ER", "HR", "BB", "SO", "HB", "CS", "TBF", "SB", "NP", "WPCT", "OBP", "SLG", "GO_AO", "OPS", "BB_9", "H_9", "K_9", "K_BB", "P_IP", "AVG", "WHIP"];
        }
    }

    public static function resetStatistic(Game $game)
    {
        DB::table('statshitting')->where("Games_idgame",$game->idgame)->delete();
        DB::table('statsfielding')->where("Games_idgame",$game->idgame)->delete();
        DB::table('statspitching')->where("Games_idgame",$game->idgame)->delete();

        $lineups = $game->lineups;
        foreach($lineups as $lineup){
            $batters = $lineup->batters;
            $hasHD = Lineup::hasDH($batters);
            foreach(Lineup::takeHitters($batters,$hasHD) as $batter){
                DB::table('statshitting')->insert(['Players_idplayer'=>$batter->Players_idplayer, 'Games_idgame'=>$game->idgame]);
            }
            foreach(Lineup::takeFielders($batters,$hasHD) as $batter){
                DB::table('statsfielding')->insert(['Players_idplayer'=>$batter->Players_idplayer, 'Games_idgame'=>$game->idgame]);
            }
            foreach(Lineup::takePitchers($batters) as $batter){
                DB::table('statspitching')->insert(['Players_idplayer'=>$batter->Players_idplayer, 'Games_idgame'=>$game->idgame]);
            }
        }
    }

    private function getPlayerInfo($player)
    {
        $class = [0=>'Freshman', 1=>'Sophomore', 2=>'Junior', 3=>'Senior', 4=>'Grad School'];
        return [
            'id'=>$player->idplayer,
            'number'=>$player->Number,
            'birthdate'=>$player->Birthdate,
            'name'=>$player->getFullName(),
            'bats_throws'=>$player->Bats.'/'.$player->Throws,
            'height'=>$player->Height,
            'weight'=>$player->Weight,
            'college'=>$player->College,
            'class'=> $class[$player->Class],
            'hometown'=>!empty($player->Hometown)? $player->Hometown.(!empty($player->State)? ', '.$player->State:''):'',
            'image'=>''
        ];
    }

    private function getRoster($team)
    {
        $result = [
            'pitchers'=>[],
            'catchers'=>[],
            'infielders'=>[],
            'outfielders'=>[],
            'staff'=>[]
        ];

        $positions = [
            'P' => 'pitchers', 'C' => 'catchers',
            '1B' => 'infielders', '2B' => 'infielders', '3B' => 'infielders', 'SS' => 'infielders', 'DH' => 'infielders',
            'LF' => 'outfielders', 'CF' => 'outfielders', 'RF' => 'outfielders',
            'EF' => 'staff', 'PH' => 'staff',
            'PR' => 'staff', 'CR' => 'staff',
        ];

        $players = $team->players;
        foreach($players as $player){
            $result[$positions[$player->Position]][] = $this->getPlayerInfo($player);
        }

        return $result;
    }

    private function getPlayerStatistic($player, $period)
    {
    }

    public function stats($id, $team, $period, $type)
    {
        $game = Game::findOrFail($id);
        $stats = $this->getStatistic($game,$team,$period,$type);

        if ($stats == null)
            return view('game.update.statistics',compact(['game','team','period','type','stats']))
                ->withErrors(['Lineup is not created.']);

        $keys = $this->getKeys($this->statTables[$type]);
        $totals = $this->getTotals($stats, $keys);
        return view('game.update.statistics.stats',compact(['game','team','period','type','stats','keys','totals']));
    }

    public function roster($id, $team)
    {
        $game = Game::findOrFail($id);
        $lineup = $this->getLineup($game,$team);
        if ($lineup == null)
            return null;
        $roster = $this->getRoster($lineup->team);

        return view('game.update.statistics.roster',compact(['game','team','roster']));
    }

    public function player($id, $player, $period)
    {
        $game = Game::findOrFail($id);
        $player = Player::findOrFail($player);
        $player = $this->getPlayerInfo($player);

        return view('game.update.statistics.player',compact(['game','player','period']));
    }
}
