<?php


function checkLastBases($model){
		$criteria = new CDbCriteria();
		
		$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup AND Inning = $model->Inning AND play < $model->play order by play ASC");
		$Events = Events::model()->findAll($criteria);
		$count = sizeof($Events);
		
		if ($count){
			
			
			//Last event 
			$event = $Events[$count-1];
			
			if ( $event->Inning == $model->Inning ) {
			
				//Search the number of batter in lineup
				//if (! Yii::app()->user->getState('batterNumber1') )//Search if not defined BatterNumbers 
				if ($event->b1) { //If there is a batter on base 1
					$criteria = new CDbCriteria();
					$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning <= $model->Inning and Players_idplayer=".$event->b1);
					$Batters = Batters::model()->findAll($criteria);
					
					$lastBatter = count($Batters) - 1;
					
					Yii::app()->user->setState('batterNumber1', $Batters[$lastBatter]->BatterPosition);
						
				}else Yii::app()->user->setState('batterNumber1', 0);
			
				
				Yii::app()->user->setState('batterNumber2', -1); 
			
		 //if (! Yii::app()->user->getState('batterNumber2')  ){
		 	
		 //}
				if ($event->b2) { //If there is a batter on base 1
					$criteria = new CDbCriteria();
					$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning <= $model->Inning and Players_idplayer=".$event->b2);
					$Batters = Batters::model()->findAll($criteria);
					//echo "<script> alert('B2 Position '+".$Batters[0]->BatterPosition.") </script>";	
					Yii::app()->user->setState('batterNumber2', $Batters[$lastBatter]->BatterPosition);
						
				}else Yii::app()->user->setState('batterNumber2', 0); 
				
		//echo "<script> alert('B2'+".Yii::app()->user->getState('batterNumber2').") </script>";
			
			//if (! Yii::app()->user->getState('batterNumber3') )
				if ($event->b3) { //If there is a batter on base 1
					$criteria = new CDbCriteria();
					$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning <= $model->Inning and Players_idplayer=".$event->b3);
					$Batters = Batters::model()->findAll($criteria);
					Yii::app()->user->setState('batterNumber3', $Batters[$lastBatter]->BatterPosition);
						
				}else Yii::app()->user->setState('batterNumber3', 0);
					
				if ($event->b1)	
					if ( Yii::app()->user->getState('hitterBase1') == NULL ){
						Yii::app()->user->setState('hitterBase1',$event->b1);
					}
					
				if ($event->b2)	
					if ( Yii::app()->user->getState('hitterBase2') == NULL ){
						Yii::app()->user->setState('hitterBase2',$event->b2);
					}
					
				if ($event->b3)	
					if ( Yii::app()->user->getState('hitterBase3') == NULL ){
						Yii::app()->user->setState('hitterBase3',$event->b3);	
					}
						
			}
		} 
		
}	


function resetBases(){
	Yii::app()->user->setState('hitterBase1',0);
	Yii::app()->user->setState('hitterBase2',0);
	Yii::app()->user->setState('hitterBase3',0);
	Yii::app()->user->setState('hitterBase4',0);
	Yii::app()->user->setState('batterNumber1',0);
	Yii::app()->user->setState('batterNumber2',0);
	Yii::app()->user->setState('batterNumber3',0);	
	Yii::app()->user->setState('batterNumber4',0);	
	
	echo "<script> var batterNumber1 = 0;</script>";
	echo "<script> var batterNumber2 = 0;</script>";
	echo "<script> var batterNumber3 = 0;</script>";
	echo "<script> var batterNumber4 = 0;</script>";
	echo "<script> var hitterBase1 = 0;</script>";	
	echo "<script> var hitterBase2 = 0;</script>";	
	echo "<script> var hitterBase3 = 0;</script>";	
	echo "<script> var hitterBase4 = 0;</script>";
	
	/*echo "<script> var idevents = 0;</script>";
	echo "<script> var Events_type_idevents_type = 0;</script>";
	echo "<script> var turntobat = 0;</script>";
	echo "<script> var Lineup_idlineup = 0;</script>";
	echo "<script> var play = 0;</script>";	*/

		
}

function setBattingTeamName($model){
	//Set the lineup ID
	//echo "<script> alert('testLin'+".$model->Lineup_idlineup .");  </script>";
	//echo "<script> alert('testbat'+".Yii::app()->user->getState('battingteam').");  </script>";
	
	if ( ! Yii::app()->user->getState('battingteam') ){
		Yii::app()->user->setState('battingteam',Yii::app()->user->getState('idteamvisiting'));
		$model->Lineup_idlineup = Yii::app()->user->getState('idlineupvisiting');
		$battingteam = Yii::app()->user->getState('idteamvisiting');
		$defensiveteam = Yii::app()->user->getState('idteamhome');
		Yii::app()->user->setState('$defensiveteam', strtoupper( Yii::app()->user->getState('teamhome'))) ;
		echo "<script> defensiveteam  = $defensiveteam </script>";
	}else{
		if (Yii::app()->user->getState('battingteam') == Yii::app()->user->getState('idteamhome')){
			//$model->Lineup_idlineup = Yii::app()->user->getState('idlineuphome');
			Yii::app()->user->setState('$battingteamName', strtoupper(Yii::app()->user->getState('teamhome'))) ;
			Yii::app()->user->setState('$defensiveteam', strtoupper( Yii::app()->user->getState('teamvisiting'))) ;
			$defensiveteam = Yii::app()->user->getState('idteamvisiting');
		}else {
			Yii::app()->user->setState('battingteam',Yii::app()->user->getState('idteamvisiting'));
			//$model->Lineup_idlineup = Yii::app()->user->getState('idlineupvisiting');
			Yii::app()->user->setState('$battingteamName', strtoupper(Yii::app()->user->getState('teamvisiting'))) ;
			Yii::app()->user->setState('$defensiveteam',strtoupper( Yii::app()->user->getState('teamhome'))) ;
			$defensiveteam = Yii::app()->user->getState('idteamhome');
		}
	}
	//echo "<script> alert('testlinsale'+".$model->Lineup_idlineup .");  </script>";
	//echo "<script> alert('testbatsale'+".Yii::app()->user->getState('battingteam').");  </script>";
	
	return $defensiveteam;
}


//Returns the last base of the player in the inning
function checkAvancePlayer($player, $idLineup, $batterNumber,$inning,$turntobat){
		
//echo "Data:". $idLineup . "-".$batterNumber."-".$inning."-".$turntobat;
$criteria = new CDbCriteria();
$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat>=$turntobat AND Batter=$batterNumber AND Inning=$inning ");
$eventsArray = Events::model()->findAll($criteria);
$count_eventsArray = count ($eventsArray);

//echo "Count events:" .$count_eventsArray;
$lastbase="";
$lastbaseNumber=0;

	for ($i=0; $i < $count_eventsArray; $i++){
			//echo "<BR>".$eventsArray[$i]->Events_type_idevents_type."<BR>";
				
			switch ( $eventsArray[$i]->Events_type_idevents_type  ){
				
				case 1:
					return 1;
				break;
				case 2:
					if ($lastbaseNumber == 3){
					
					$lastbase='3b';
					$lastbaseNumber=2;
					}
				break;
				case 3:
					if ($lastbaseNumber == 4){
					
					$lastbase='2b';
					$lastbaseNumber=3;
					}
				break;
				case 4:
					if ($lastbaseNumber < 1){
					
					$lastbase='1b';
					$lastbaseNumber=4;
					}
				break;
				case 40:
					if ($lastbaseNumber < 40){
					
					$lastbase='2b';
					$lastbaseNumber=40;
					}
				break;
				case 41:
					if ($lastbaseNumber < 41){
						$lastbase='3b';
						$lastbaseNumber = 41;
					}
				break;
				case 42:
					return 42;
				break;
				case 37:
					return $lastbaseNumber;
				break;
			} 
		
		
	}
	return $lastbaseNumber;
}

?>