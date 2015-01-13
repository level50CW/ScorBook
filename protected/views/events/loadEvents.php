<?php
  

function loadEvent($id){
	
	if ($idevent=$id) {
				$criteria = new CDbCriteria();
				$criteria->addcondition("idevents=$idevent");
				$event = Events::model()->findAll($criteria);
				
				$model = $event[0];
				
				
				$lin=$event[0]->Lineup_idlineup;
				//echo "<script> alert('eventlineup:'+$lin) </script>";
				$model->Lineup_idlineup = $event[0]->Lineup_idlineup;
				$model->Inning = $event[0]->Inning;
				
				//Load lineup by eventid
				$criteria = new CDbCriteria();
				$criteria->addcondition("idlineup=$model->Lineup_idlineup");
				$lineup = Lineup::model()->findAll($criteria);
				
				Yii::app()->user->setState('batterNumber',$event[0]->Batter);
				Yii::app()->user->setState('turntobat',$event[0]->turntobat);
				
				Yii::app()->user->setState('hitterBase1',$event[0]->b1);
				Yii::app()->user->setState('hitterBase2',$event[0]->b2);
				Yii::app()->user->setState('hitterBase3',$event[0]->b3);	
				
				//Search the number of batter in lineup
				if ($event[0]->b1) {
					//LOAD BATTERS
					$criteria = new CDbCriteria();
					$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning = $model->Inning and Players_idplayer=".$event[0]->b1);
					$Batters = Batters::model()->findAll($criteria);
					Yii::app()->user->setState('batterNumber1', $Batters[0]->BatterPosition);
				}
				
				
				
				//Yii::app()->user->setState('batterNumber2',$event[0]->b2);
				//Yii::app()->user->setState('batterNumber3',$event[0]->b3);	
				
				
				$model->idevents = $idevent;
				
				 
				
				//Get the last base of the player in the Inning
				//$lastbase = checkAvancePlayer($Batters[0]->Players_idplayer, $lineup[0]->idlineup, $Batters[0]->BatterPosition,$event[0]->Inning,$event[0]->turntobat);
				
				//$criteria = new CDbCriteria();
				//$criteria->addcondition("play=$event[0]->play");
				//$eventByPlay = Events::model()->findAll($criteria);
					if ($event[0]->b1) { //If there is a batter on base 1
							$criteria = new CDbCriteria();
							$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning = $model->Inning and Players_idplayer=".$event[0]->b1);
							$Batters = Batters::model()->findAll($criteria);
							Yii::app()->user->setState('batterNumber1', $Batters[0]->BatterPosition);
								
						}else Yii::app()->user->setState('batterNumber1', 0);
					
					//echo "<script> alert('B2'+$event->b2) </script>";
						echo "<script> var batterNumber1=".$Batters[0]->BatterPosition;
					
				 //if (! Yii::app()->user->getState('batterNumber2')  ){
				 	
				 //}
						if ($event[0]->b2) { //If there is a batter on base 1
							$criteria = new CDbCriteria();
							$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning = $model->Inning and Players_idplayer=".$event[0]->b2);
							$Batters = Batters::model()->findAll($criteria);
							//echo "<script> alert('B2 Position '+".$Batters[0]->BatterPosition.") </script>";	
							Yii::app()->user->setState('batterNumber2', $Batters[0]->BatterPosition);
								
						}else Yii::app()->user->setState('batterNumber2', 0); 
						
						echo "<script> var batterNumber2=".$Batters[0]->BatterPosition;
						
					//if (! Yii::app()->user->getState('batterNumber3') )
						if ($event[0]->b3) { //If there is a batter on base 1
							$criteria = new CDbCriteria();
							$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning = $model->Inning and Players_idplayer=".$event[0]->b3);
							$Batters = Batters::model()->findAll($criteria);
							Yii::app()->user->setState('batterNumber3', $Batters[0]->BatterPosition);
							
								
						}else Yii::app()->user->setState('batterNumber3', 0);
						echo "<script> var batterNumber3=".$Batters[0]->BatterPosition;
					
					
					echo "<script> var idevents=$idevent;";
					echo "var Events_type_idevents_type = $model->Events_type_idevents_type ";
					echo "var hitterBase1=".$event[0]->b1;
					echo "var hitterBase2=".$event[0]->b2;
					echo "var hitterBase3=".$event[0]->b3;
					echo "var turntobat=".$event[0]->turntobat;
					echo "var batterNumber=".$event[0]->Batter;
					echo "</script>";
					
					
					//Draw and load the event
					
					/* switch ($event[0]->Events_type_idevents_type) {
					
					case 1:
						echo "<script> fillplate() ; </script>"; 
					break;
					case 2: //3B
						echo "<script> fill3b(0); ; </script>";
						
					break;
					
					case 3: //2B
						//Yii::app()->user->setState('hitterBase2',$idplayer);
						echo "<script> fill2b(0); </script>";
						
					break;
					
					case 4: //1B
						echo "<script> fill1b(0) ; </script>";
						
						//Yii::app()->user->setState('hitterBase1',$idplayer);
					break;
					
					case 5: 
						echo "<script> fillbb(0) ; </script>";
						
					break;
					case 6 : //BB HP
						
						
					break;
					
					
					case 37:  //Event is out
						
						
					break;
					
					case 40:
						echo "<script> fill2b(0);</script>";
						
					break;
					
					case 41:
						echo "<script> fill3b(0); </script>";
						
					break;
					
					case 42:
						echo "<script> fillplate(0); </script>";
						
					break;
					
					
				}*/
			}
}
?>