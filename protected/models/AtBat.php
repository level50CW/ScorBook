<?php

class AtBat
{
	public function loadState()
	{
		$state = new stdClass;
		$state->idgame = Yii::app()->user->getState('idgame');
		$state->idteamhome = Yii::app()->user->getState('idteamhome');
		$state->idteamvisiting = Yii::app()->user->getState('idteamvisiting');
		$state->teamhome = Yii::app()->user->getState('teamhome');
		$state->teamvisiting = Yii::app()->user->getState('teamvisiting');
		$state->battingteam = Yii::app()->user->getState('battingteam');
		$state->batterNumber = Yii::app()->user->getState('batterNumber');
		$state->inning = Yii::app()->user->getState('inning');
		$state->idlineuphome = Yii::app()->user->getState('idlineuphome');
		$state->idlineupvisiting = Yii::app()->user->getState('idlineupvisiting');
		
		return $state;
	}
	
	public function loadTableRuns($idgame, $idteam)
	{
		//Load runs
		$runsArray = Runs::getByGameTeam($idgame, $idteam);

		if (count($runsArray)) {
			$runs = $runsArray[0];
		} else {
			$runs = new Runs;
		}

		$stdRuns = new stdClass;
		
		for ($i = 1; $i <=9; $i++) {
			$stdRuns->{"inning$i"} = $runs->{"inning$i"};
		}
		
		$stdRuns->_empty = '';
		$stdRuns->R = $runs->R;
		$stdRuns->H = $runs->H;
		$stdRuns->E = $runs->E;
		
		$result = new stdClass;
		$result->runs = $stdRuns;
		$result->runsOrigin = $runs;
		
		return $result;
	}

	public function loadTableTeam($id, $state)
	{
		$teamTable = new stdClass;

		if (!$id) {
			$id = 0;
		}

		$idLineup = $id;
		$lineup   = Lineup::getById($idLineup);


		if (!$teamid = $lineup[0]->Teams_idteam) {
			$teamid = 0;
		}

		$teamTable->name = $state->idteamhome == $teamid ? $state->teamhome : $state->teamvisiting;

		$Batters = Batters::getByLineup($idLineup);
		$count = sizeof($Batters);

		$StatshittingArray = Statshitting::getByGame($state->idgame);
		$count_stats_hit   = count($StatshittingArray);

		$StatsfieldingArray = Statsfielding::getByGame($state->idgame);
		$count_stats_field  = count($StatsfieldingArray);

		
		$teamTable->battersOrigin = $Batters;
		
		$teamTable->pitcherIndexes = array();
		$teamTable->batters = array();
		
		for ($i = 0; $i < $count; $i++) {			
			$teamTable->batters[$i]->isSelected = false;

			//Select Pitcher || $Batters[$i]->DefensePosition == "11"
			if ($Batters[$i]->DefensePosition == "1") {
				$teamTable->pitcherIndexes[] = $i;
				$teamTable->batters[$i]->isPitcher = true;
			}

			$player = Players::model()->findByPk($Batters[$i]->Players_idplayer); //CAMBIAR LIST de USUARIOS
			$teamTable->batters[$i]->player = $player;

			//Player at Bat
			if ($state->battingteam == $teamid && $state->batterNumber == $i + 2) {
				$teamTable->batters[$i]->isSelected = true;
				$number = $i + 1;
			}

			$e = 0;
			$Statshitting = new Statshitting;
			for ($e; $e < $count_stats_hit; $e++) {
				if ($StatshittingArray[$e]->Players_idplayer == $player->idplayer) {
					$Statshitting = $StatshittingArray[$e];
					$e = $count_stats_hit;
				}
			}

			if ($Batters[$i]->DefensePosition != "1") {
				
				$teamTable->batters[$i]->isPitcher = false;
		
				$stdStatshitting = new stdClass;
				$stdStatshitting->AB = $Statshitting->AB;
				$stdStatshitting->H = $Statshitting->H;
				$stdStatshitting->RBI = $Statshitting->RBI;
				$stdStatshitting->BB = $Statshitting->BB;
				$stdStatshitting->SO = $Statshitting->SO;
				$stdStatshitting->RBI = $Statshitting->RBI;
				
				$teamTable->batters[$i]->Statshitting = $stdStatshitting;
				$teamTable->batters[$i]->StatshittingOrigin = $Statshitting;
			}
		}

		//Load stats of players
		$StatspitchingArray = Statspitching::getByGame($state->idgame);
		$count_stats_pit = count($StatspitchingArray);

		for ($o = 0; $o < count($teamTable->pitcherIndexes); $o++) {
			$i      = $teamTable->pitcherIndexes[$o];
			$player = $teamTable->batters[$i]->player;

			$e = 0;
			$Statspitching = new Statspitching;
			//Search the pitcher stats
			for ($e; $e < $count_stats_pit; $e++) {
				if ($StatspitchingArray[$e]->Players_idplayer == $player->idplayer) {
					$Statspitching = $StatspitchingArray[$e];
					$e = $count_stats_pit;
				}
			}

			if ($state->inning == 1) {
				$Statspitching->GS = 1;
			} else {
				$Statspitching->GS = 0;
			}

			//The total number of games in which the pitcher appeared, whether as the starter or as a reliever.
			if (!$Statspitching->G) {
				$Statspitching->G = 1;
			}

			$stdStatspitching = new stdClass;
			$stdStatspitching->IP = $Statspitching->IP;
			$stdStatspitching->H = $Statspitching->H;
			$stdStatspitching->R = $Statspitching->R;
			$stdStatspitching->BB = $Statspitching->BB;
			$stdStatspitching->SO = $Statspitching->SO;
			$stdStatspitching->B = $Statspitching->B;
			$stdStatspitching->S = $Statspitching->S;
			
			$teamTable->batters[$i]->Statspitching = $stdStatspitching;
			$teamTable->batters[$i]->StatspitchingOrigin = $Statspitching;
		}
		
		return $teamTable;
	}

}