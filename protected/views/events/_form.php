
<script>
	
	document.getElementById("content").style.width = "1100px";
	document.getElementById("page").style.width = "1100px";
	

</script>

<?php



function printLogo ($id){
	
  	
	$team = Teams::model()->findByPk($id);
	
	
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
	{
	    // User agent is Google Chrome
	    $position = 'top: 25px; right: 50px;';
	}else $position = 'top: -100px;';
	
	if ($team->thumb) {
		echo "<img  style='position: relative; $position' src='images/thumbs/$team->thumb'/> </img>";
	 	
	}
		
}

function loadEvents($id){
	
	
	$str1="";
				
	if ($idevent=$id) {
		
		$criteria = new CDbCriteria();
		$criteria->addcondition("idevents=$idevent");
		$event = Events::model()->findByPk($idevent);
		
		echo Yii::trace(CVarDumper::dumpAsString($idevent),'battervar179');
		
				
		$criteria = new CDbCriteria();
		$play = $event->play;
		$criteria->addcondition("play=$play AND Lineup_idlineup=".$event->Lineup_idlineup );
		$eventByPlay = Events::model()->findAll($criteria);
		
		
		for ($o=0; $o < count($eventByPlay); $o++) {
				
				$event = $eventByPlay[$o];

				$model = $event;
				
				//echo "<script> alert($str1); </script>";
				
				$lin=$event->Lineup_idlineup;
				//echo "<script> alert('eventlineup:'+$lin) </script>";
				$model->Lineup_idlineup = $event->Lineup_idlineup;
				$model->Inning = $event->Inning;
				
				//Load lineup by eventid
				$criteria = new CDbCriteria();
				$criteria->addcondition("idlineup=$model->Lineup_idlineup");
				$lineup = Lineup::model()->findAll($criteria);
				
				Yii::app()->user->setState('batterNumber',$event->Batter);
				Yii::app()->user->setState('turntobat',$event->turntobat);
				
				Yii::app()->user->setState('hitterBase1',$event->b1);
				Yii::app()->user->setState('hitterBase2',$event->b2);
				Yii::app()->user->setState('hitterBase3',$event->b3);	
				
				//Search the number of batter in lineup
				if ($event->b1) {
					//LOAD BATTERS
					$criteria = new CDbCriteria();
					$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning = $model->Inning and Players_idplayer=".$event->b1);
					$Batters = Batters::model()->findAll($criteria);
					Yii::app()->user->setState('batterNumber1', $Batters->BatterPosition);
				}
				
				
				
				//Yii::app()->user->setState('batterNumber2',$event[0]->b2);
				//Yii::app()->user->setState('batterNumber3',$event[0]->b3);	
				
				
				$model->idevents = $event->idevents;
				
				 
				
				//Get the last base of the player in the Inning
				//$lastbase = checkAvancePlayer($Batters[0]->Players_idplayer, $lineup[0]->idlineup, $Batters[0]->BatterPosition,$event[0]->Inning,$event[0]->turntobat);
				
				//$criteria = new CDbCriteria();
				//$criteria->addcondition("play=$event[0]->play");
				//$eventByPlay = Events::model()->findAll($criteria);
					if ($event->b1) { //If there is a batter on base 1
							$criteria = new CDbCriteria();
							$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning <= $model->Inning and Players_idplayer=".$event->b1);
							$Batters = Batters::model()->findAll($criteria);
							
							$lastBatter = count($Batters) - 1;
							
							Yii::app()->user->setState('batterNumber1', $Batters[$lastBatter]->BatterPosition);
								
						}else Yii::app()->user->setState('batterNumber1', 0);
					
					//echo "<script> alert('B2'+$event->b2) </script>";
						if ($Batters[$lastBatter]->BatterPosition) $str.= " var batterNumber1=".$Batters[$lastBatter]->BatterPosition.";";
					

						if ($event->b2) { //If there is a batter on base 1
							$criteria = new CDbCriteria();
							$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning <= $model->Inning and Players_idplayer=".$event->b2);
							$Batters = Batters::model()->findAll($criteria);
							$lastBatter = count($Batters) - 1;
							//echo "<script> alert('B2 Position '+".$Batters[0]->BatterPosition.") </script>";	
							Yii::app()->user->setState('batterNumber2', $Batters[$lastBatter]->BatterPosition);
								
						}else Yii::app()->user->setState('batterNumber2', 0); 
						
						if ($Batters[$lastBatter]->BatterPosition) $str .=  "var batterNumber2=".$Batters[$lastBatter]->BatterPosition.";";
						
						if ($event->b3) { //If there is a batter on base 1
							$criteria = new CDbCriteria();
							$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning <= $model->Inning and Players_idplayer=".$event->b3);
							$Batters = Batters::model()->findAll($criteria);
							$lastBatter = count($Batters) - 1;
							Yii::app()->user->setState('batterNumber3', $Batters[$lastBatter]->BatterPosition);
							
								
						}else Yii::app()->user->setState('batterNumber3', 0);
						if ($Batters[$lastBatter]->BatterPosition) $str .=  " var batterNumber3=".$Batters[$lastBatter]->BatterPosition.";";
					
					
					$str .=  " idevents=$event->idevents;";
					$str .=  " Events_type_idevents_type = $event->Events_type_idevents_type ;";
					$str .=  " hitterBase1=".$event->b1.";";
					$str .=  " hitterBase2=".$event->b2.";";
					$str .=  " hitterBase3=".$event->b3.";";
					$str .=  " turntobat=".$event->turntobat.";";
					$str .=  " batterNumber=".$event->Batter.";";
					$str .=  " Lineup_idlineup=".$event->Lineup_idlineup.";";
					$str .=  " play=".$event->play.";";
					
					//Quotes fix for MISCE
					$event->Misce = "'".$event->Misce."'";
					
					if ($event->Misce) $str .=  " Misce =".$event->Misce.";";
					if ($event->text) $str .=  " text ='".$event->text."';";
					if ($event->ER) $str .=  " ER ='".$event->ER."';";
					if ($event->RBI) $str .=  " RBI ='".$event->RBI."';";
					
					if ($event->playerid) $str .=  " playerid =".$event->playerid.";";
					if ($event->batterNumberOut) $str .=  " batterNumberOut =".$event->batterNumberOut.";";
					
					
					
					
					//echo "<script> alert($str); </script>";
					
					
					//Draw and load the event
					
		
					switch ($event->Events_type_idevents_type) {
					
					case 1:
						$str .= " fillhr(0) ; "; 
					break;
					case 2: //3B
						$str .= " fill3b(0); ";
						
					break;
					
					case 3: //2B
						//Yii::app()->user->setState('hitterBase2',$idplayer);
						$str .= "fill2b(0);";
						
					break;
					
					case 4: //1B
						$str .=  " fill1b(0) ;";
						
						//Yii::app()->user->setState('hitterBase1',$idplayer);
					break;
					
					case 5: //BB
						$str .= " fillbb(0) ; ";
						
					break;
					case 6 : //BB HP
						$str .= " fillhp(0) ; ";
					break;
					
					case 7 : //KSO
						$str .= "fillKSO(1,0);";
					break;
					
					case 8 : //KS
						$str .= "fillKS(1,0);";
					break;
					
					case 9 : //K23
						$str .= "fillK23(0);";
					break;
					
					case 10 : //K2
						$str .= "fillK2(0);";
					break;
					
					case 11 : //KSE
						$str .= "fillKSE(0);";
					break;
					
					case 12 : //KFC
						$str .= "fillKFC(0);";
					break;
					
					case 13 : //KPB
						$str .= "fillKPB(0);";
					break;
					
					case 14 : //KWP
						$str .= "fillKWP(0);";
					break;
					
					case 15 : //FCAR
						$str .= "fillFCAR(0);";
					break;
					
					case 16 : //FCNB
						$str .= "fillFCNB(0);";
					break;
					
					case 17 : //R1po
						$str .= "fillR1po(0);";
					break;
					
					case 18 : //R2po
						$str .= "fillR2po(0);";
					break;
					
					case 19 : //R3po
						$str .= "fillR3po(0);";
					break;
					
					case 20 : //KFCAR
						$str .= "fillKFCAR(0);";
					break;
					
					case 21 : //KFCNB
						$str .= "fillKFCNB(0);";
					break;
					
					case 22 : //KR1po
						
						//Set the player on base again
						$str .=  " hitterBase1=".$event->playerid.";"; //Player out
						
						$str .= "fillKR1po(0);";
					break;
					
					case 23 : //KR2po
						
						$str .= "fillKR2po(0);";
					break;
					
					case 24 : //KR3po
						
						$str .= "fillKR3po(0);";
					break;
					
					case 25 : //4sac
						
						$str .= "fill4sac(0);";
					break;
					
					case 26 : //3sac
						
						$str .= "fill3sac(0);";
					break;
					
					case 27 : //2sac
						
						$str .= "fill2sac(0);";
					break;
					
					case 28 : //1sac
						
						$str .= "fill1sac(0);";
					break;
					
					case 29 : //0sacFCAR
						
						$str .= "fill0sacFCAR(0);";
					break;
					
					case 30 : //0sacFCNB
						
						$str .= "fill0sacFCNB(0);";
					break;
					
					case 31 : //ball2
						
						$str .= "fillball(1,0);";
					break;
					
					case 32 : //ball1
						
						$str .= "fillball(2,0);";
					break;
					
					case 33 : //ball1
						
						$str .= "fillball(3,0);";
					break;
					
					case 34 : //ball1
						
						$str .= "fillball(4,0);";
					break;
					
					case 35 : //ball5
						
						$str .= "fillball(5,0);";
					break;
					
					case 35 : //ball6
						
						$str .= "fillball(6,0);";
					break;
					
					case 37:  //Event is out
							
						 // if (  ($eventByPlay[$o+1]->Events_type_idevents_type != 7 ) ){
								
							$outtxt = $event->OutText;
							
							while ( strlen( $outtxt  ) > 0 ) {
								$str .= "out(".substr( $outtxt,0,1).",0);";
								if (strlen( $outtxt ) > 2) $outtxt = substr($outtxt, 2,strlen( $outtxt ) );
								else $outtxt = "";
									
							//}
				
						}
						
						
					break;
					
					case 38 : //Ball tray
						$x = strstr($event->Misce, '-',true);	
						$y = strstr($event->Misce, '-')*-1;
						
						$str .= "fillballtray($x,$y);";
					break;
					
					case 40:
						$str .= "runb1(0);";
						
					break;
					
					case 41:
						$str .= " runb2(0); ";
						
					break;
					
					case 42:
						$str .= " runb3(0); ";
						
					break;
					
					case 43:
						$str .= " fillError('E0',$event->Misce); ";
					break;
					
					case 44:
						$str .= " fillError('E9',$event->Misce); ";
					break;
					
					case 45:
						$str .= " fillError('E8',$event->Misce); ";
					break;
					
					case 46:
						$str .= " fillError('E7',$event->Misce); ";
					break;
					
					case 47:
						$str .= " fillError('E6',$event->Misce); ";
					break;
					
					case 48:
						$str .= " fillError('E5',$event->Misce); ";
					break;

					case 49:
						$str .= " fillError('E4',$event->Misce); ";
					break;
					
					case 50:
						$str .= " fillError('E3',$event->Misce); ";
					break;
					
					case 51:
						$str .= " fillError('E2',$event->Misce); ";
					break;
					
					case 52:
						$str .= " fillError('E1',$event->Misce); ";
					break;
					
					case 53:
						$str .= " fillError('E0',$event->Misce); ";
					break;
					
					case 53:
						$str .= " fillCS($event->Misce,0); ";
					break;
					
					case 54:
						$str .= " fillCS26(0); ";
					break;
					
					case 55:
						$str .= " fillCS25(0); ";
					break;
					
					case 57: 
					case 58:
					case 59: 
					case 60:
					case 61: 
					case 62:
					case 63: 
					case 64:
					case 65: 	
						$str .= " fillE0foulby($event->Misce,0); ";
					break;
					
					case 66: 	
						$str .= " fillSB($event->Misce,0); ";
					break;
					
					case 67: 	
						$str .= " fillPB($event->Misce,0); ";
					break;
					
					case 68: 	
						$str .= " fillWP($event->Misce,0); ";
					break;
					
					case 69: 	
						$str .= " fillBK($event->Misce,0); ";
					break;
					
					case 70: 	
						$str .= " fillSBNStat($event->Misce,0); ";
					break;
					
					case 71: 	
						$str .= " fillPBNStat($event->Misce,0); ";
					break;
					
					case 72: 	
						$str .= " fillWPNStat($event->Misce,0); ";
					break;
					
					case 73: 	
						$str .= " fillBKNStat($event->Misce,0); ";
					break;
					
					case 74: 	
						$str .= " fillO($event->Misce); ";
					break;
					
					case 75: 	
						$str .= " fillDI($event->Misce); ";
					break;
					
					case 76: 	
						$str .= " fillFC($event->Misce); ";
					break;
					
					case 77: 	
						$str .= " LastBatter(); ";
					break;
					
					case 78: 	
						$str .= " SkipBatter(); ";
					break;
				}
					
				
				
			}
			
		}

	return $str;
}
	
	


/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */

$idgame = Yii::app()->user->getState('idgame');

echo "<script> var ballnumber = 0;</script>";
echo "<script> var ball1 = 0;</script>";
echo "<script> var ball2 = 0;</script>";
echo "<script> var ball3 = 0;</script>";
echo "<script> var ball4 = 0;</script>";
echo "<script> var ball5 = 0;</script>";
echo "<script> var deleteBallflag = 0;</script>";
echo "<script> var deleteBallPos = new Array();deleteBallPos[0]=0 </script>";


if ($hitterBase1=Yii::app()->user->getState('hitterBase1')) {
	echo "<script> var hitterBase1 = $hitterBase1;</script>";
}else
	echo "<script> var hitterBase1 = 0;</script>";
	
if ($hitterBase2=Yii::app()->user->getState('hitterBase2')) {
	echo "<script> var hitterBase2 = $hitterBase2;</script>";
}else
	echo "<script> var hitterBase2 = 0;</script>";

if ($hitterBase3=Yii::app()->user->getState('hitterBase3')) {
	echo "<script> var hitterBase3 = $hitterBase3;</script>";
}else
	echo "<script> var hitterBase3 = 0;</script>";
	
if ($hitterBase4=Yii::app()->user->getState('hitterBase4')) {
	echo "<script> var hitterBase4 = $hitterBase4;</script>";
}else
	echo "<script> var hitterBase4 = 0;</script>";
	

if ($batterNumber=Yii::app()->user->getState('batterNumber')) {
	echo "<script> var batterNumber = $batterNumber;</script>";
}else
	echo "<script> var batterNumber = 1;</script>";

if ($batterNumber1=Yii::app()->user->getState('batterNumber1')) {
	echo "<script> var batterNumber1 = $batterNumber1;</script>";
}else
	echo "<script> var batterNumber1 = 0;</script>";
	
if ($batterNumber2=Yii::app()->user->getState('batterNumber2')) {
	echo "<script> var batterNumber2 = $batterNumber2;</script>";
}else
	echo "<script> var batterNumber2 = 0;</script>";

if ($batterNumber3=Yii::app()->user->getState('batterNumber3')) {
	echo "<script> var batterNumber3 = $batterNumber3;</script>";
}else
	echo "<script> var batterNumber3 = 0;</script>";

if ($batterNumber4=Yii::app()->user->getState('batterNumber4')) {
	echo "<script> var batterNumber4 = $batterNumber4;</script>";
}else
	echo "<script> var batterNumber4 = 0;</script>";
	
//echo "<BR>OUT:".$Outs=Yii::app()->user->getState('outs');
if ($Outs=Yii::app()->user->getState('outs')) {
	echo "<script> var outs = $Outs;</script>";
}else $Outs = 0;



/*echo "<script> alert('*Batternumber *' +".Yii::app()->user->getState('batt').");</script>";
echo "<script> alert('Batternumber1:' +batterNumber1);</script>";
echo "<script> alert('Batternumber2:' +batterNumber2);</script>";
echo "<script> alert('Batternumber3:' +batterNumber3);</script>";
 * */
 
				
?>




<script>
	
	
	var battingteam = <? echo Yii::app()->user->getState('battingteam');?>
	
</script>

<script src="js/undoAtBat.js" type="text/javascript" charset="utf-8"></script>
<script src="js/stats.js" type="text/javascript" charset="utf-8"></script>
<script src="js/atbat.js" type="text/javascript" charset="utf-8"></script>



<?

function loadTableRuns ($idgame,$idteam,$form){
	//Load runs
									
	$criteria = new CDbCriteria();
	$criteria->addcondition("games_idgame=$idgame AND teams_idteam =". $idteam);
	$runs = new Runs;
	$runsArray = Runs::model()->findAll($criteria);
	
	if ( count($runsArray) ){
		$runs = $runsArray[0] ;
		//echo "<script> alert('yes'); </script>";
	} 
	?>	
	
	<?
	
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning1[]', array('value'=>$runs->inning1,"id"=>"r1".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning2[]', array('value'=>$runs->inning2,"id"=>"r2".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning3[]', array('value'=>$runs->inning3,"id"=>"r3".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning4[]', array('value'=>$runs->inning4,"id"=>"r4".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning5[]', array('value'=>$runs->inning5,"id"=>"r5".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning6[]', array('value'=>$runs->inning6,"id"=>"r6".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning7[]', array('value'=>$runs->inning7,"id"=>"r7".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning8[]', array('value'=>$runs->inning8,"id"=>"r8".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'inning9[]', array('value'=>$runs->inning9,"id"=>"r9".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	
	
	echo "<td></td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'R[]', array('value'=>$runs->R,"id"=>"r11".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'H[]', array('value'=>$runs->H,"id"=>"r12".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo "<td style='border: 1px solid' class='white'>".$form->textfield($runs, 'E[]', array('value'=>$runs->E,"id"=>"r13".$idteam,"class"=>"inputnumbersinning",'readonly'=>"true") ) ."</td>";
	echo $form->hiddenfield($runs, 'teams_idteam[]', array("value"=>$idteam,'readonly'=>"true") );
	echo $form->hiddenfield($runs, 'games_idgame[]', array("value"=>$idgame,'readonly'=>"true") ) ;
	echo $form->hiddenfield($runs, 'idrun[]', array("value"=>$runs->idrun,'readonly'=>"true") ) ;
	
}


function loadTableTeam ($id,$form,$model){
				
	$positions = array('P', 'C', '1B', '2B', '3B','SS',
	  'LF', 'CF', 'RF', 'EF','DH', 'PH',
	  'PR',  'CR', 'EH',  'X');

	//LOAD LINEUP

	if (!$id) $id=0;

	$idLineup = $id;
	$criteria = new CDbCriteria();
	$criteria->addcondition("idlineup=$idLineup");
	$lineup = Lineup::model()->findAll($criteria);


	//LOAD TEAM INFO
	if (! $teamid=$lineup[0]->Teams_idteam) $teamid = 0 ;

	if (Yii::app()->user->getState('idteamhome') == $teamid) {
		$name = Yii::app()->user->getState('teamhome');
		echo "<script> idteamhome = $teamid </script>";
	}else {
		$name = Yii::app()->user->getState('teamvisiting');
		echo "<script> idteamvisiting = $teamid</script>";
	}
	echo Yii::trace(CVarDumper::dumpAsString( Yii::app()->user->getState('idteamvisiting') ),'teamvis');

	if ($name) echo "<tr class='blacktitle'> <td colspan=8>". $name." </td> </tr>";
	else echo "<tr> <td colspan=4> LINEUP MUST BE CREATED </td> </tr>";

	//LOAD BATTERS
	$criteria = new CDbCriteria();
	$criteria->addcondition("Lineup_idlineup=$idLineup");
	$Batters = Batters::model()->findAll($criteria);

	$count = sizeof($Batters);

	//Load stats of players Hitting
	$criteria = new CDbCriteria();
	$idgame = Yii::app()->user->getState('idgame');
	$criteria->addcondition("Games_idgame=$idgame");
	$Statshitting = new Statshitting;
	$StatshittingArray = Statshitting::model()->findAll($criteria);

	$count_stats_hit = count ($StatshittingArray);

	//Load stats of players fielding
	$criteria = new CDbCriteria();
	//$idgame = Yii::app()->user->getState('idgame');
	$criteria->addcondition("Games_idgame=$idgame");
	$Statsfielding = new Statsfielding;
	$StatsfieldingArray = Statsfielding::model()->findAll($criteria);

	$count_stats_field = count ($StatsfieldingArray);

	//echo Yii::trace(CVarDumper::dumpAsString($rows),'varsearch');
	echo "<tr class='greentr'>";
		echo "<td colspan=3 style='width: 30%'> Lineup </td> <td>AB</td> <td>H</td> <td>RBI</td> <td>BB</td> <td>SO</td>";
	echo "</tr>";


	//Set the number of players at bat
	if ( Yii::app()->user->getState('battingteam') == $teamid){
		Yii::app()->user->setState('batters_number', $count);
		echo "<script> var batters_number =  $count </script>";

			//echo "<script> alert('BattersCountForm'+ $count) </script>";
			//echo "<script> alert('BatterForm'+".Yii::app()->user->getState('batter').") </script>";
			//echo "<script> alert('TurntobatForm'+".Yii::app()->user->getState('turntobat').") </script>";

		//Go to  batter1
		if (Yii::app()->user->getState('batterNumber') > $count){
			Yii::app()->user->setState('turntobat', Yii::app()->user->getState('turntobat')+1);
			Yii::app()->user->setState('batterNumber',1);
			$model->Batter=1;


		}else $model->Batter = Yii::app()->user->getState('batterNumber');


		//echo "<script> alert('BatterFormCambiado ?'+".Yii::app()->user->getState('batter').") </script>";

		$batternumber = Yii::app()->user->getState('batterNumber'); //Number of batter at lineup
		$turntobat = Yii::app()->user->getState('turntobat'); //Turn to bat

		//echo "<script> document.getElementById('Events_Batter').value = '$batternumber' </script>";
		echo "<script> document.getElementById('Events_turntobat').value = '$turntobat' </script>";

		echo Yii::trace(CVarDumper::dumpAsString(Yii::app()->user->getState('batter')),'battervar');
		echo Yii::trace(CVarDumper::dumpAsString($count),'battercount');
		echo Yii::trace(CVarDumper::dumpAsString($count),'battermodel');
	}
	$pitcher = array();
	//for ($i=0;$i < $count; $i++){
	for ($i=0;$i < $count; $i++){

		//echo  "BAT".Yii::app()->user->getState('batterNumber') ;
		//echo "-$i-SUP<br> ";



		//Check sustitutions
		if ($i < $count -1 ){
			if ($Batters[$i+1]->Inning != 1) {
				if ( $Batters[$i+1]->Inning <=  Yii::app()->user->getState('inning') ){
					//Check if batterNumber == actual i loop
					if ( ( $i+1 ) == Yii::app()->user->getState('batterNumber')){
						;
					}
					$i++; //Set the next player
					Yii::app()->user->setState('batterNumber',Yii::app()->user->getState('batterNumber')+1);
				}
			}
		}

		//Check if the sustitution is not in this inning yet
		if ( $Batters[$i]->Inning != 1 &&  $Batters[$i]->Inning > Yii::app()->user->getState('inning') ){
			$i++;
			Yii::app()->user->setState('batterNumber',Yii::app()->user->getState('batterNumber')+1);
		}


		$class = "grayatbat";

		//Select Pitcher || $Batters[$i]->DefensePosition == "11"
		if ($Batters[$i]->DefensePosition == "1") {
			$pitcher[] = $i;
		}

			$player=Players::model()->findByPk($Batters[$i]->Players_idplayer); //CAMBIAR LIST de USUARIOS



			//Player at Bat
			if ( Yii::app()->user->getState('battingteam') == $teamid){


				//Style player at bat

				if ( Yii::app()->user->getState('batterNumber') == $i+2){
					$class = "brownatbat";
					$number = $i + 1;
					echo "<script  type='text/javascript'> var batter=$player->idplayer </script>"; //Batter ID
					echo "<script  type='text/javascript'> var batterNumber=$model->Batter </script>"; //Batter number
					echo "<script> $('#span-23').css('text-align','center'); $('#span-23').css('text-weight','bold');$('#span-23').html('Batter $number - #".$Batters[$i]->Number. " " .
					$player->Firstname ." ".$player->Lastname[0].", ".$positions[$Batters[$i]->DefensePosition-1] ."');</script> ";
				}


			}else{//SELECT THE FIELD PLAYERS

				//Search the player stats
				$e=0;
				if ($count_stats_field){
					for ($e;$e < $count_stats_field; $e++){
						if ($StatsfieldingArray[$e]->Players_idplayer == $player->idplayer){
							$Statsfielding =  $StatsfieldingArray[$e];
							echo $form->hiddenfield($Statsfielding,'idstatsfield[]',array('value'=>$StatsfieldingArray[$e]->idstatsfield));

							$e = $count_stats_field;
						}
					}
				}

				if (! $Statsfielding->TC ) $Statsfielding->TC = 0;
				if (! $Statsfielding->PO ) $Statsfielding->PO = 0;
				if (! $Statsfielding->A ) $Statsfielding->A = 0;
				if (! $Statsfielding->PB ) $Statsfielding->PB = 0;


				if (! $Statsfielding->E ) $Statsfielding->E = 0;
				if (! $Statsfielding->INN ) $Statsfielding->INN = 0;
				if (! $Statsfielding->CS ) $Statsfielding->CS = 0;
				if (! $Statsfielding->C_WP ) $Statsfielding->C_WP = 0;

				if (Yii::app()->user->getState('inning') == 1) {
					$Statsfielding->GS = 1;
				}else
					$Statsfielding->GS = 0;

				//The total number of games in which the pitcher appeared, whether as the starter or as a reliever.
				if (! $Statsfielding->G) $Statsfielding->G = 1;


				echo $form->hiddenfield($Statsfielding,'Players_idplayer[]',array('value'=>$player->idplayer));
				echo $form->hiddenfield($Statsfielding,'Games_idgame[]',array('value'=>$idgame));
				$strPosition=$Batters[$i]->DefensePosition;

				echo $form->hiddenfield($Statsfielding,'TC[]',array('value'=>$Statsfielding->TC,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fTC$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'PO[]',array('value'=>$Statsfielding->PO,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fPO$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'A[]',array('value'=>$Statsfielding->A,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fA$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'PB[]',array('value'=>$Statsfielding->PB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fPB$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'E[]',array('value'=>$Statsfielding->E,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fE$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'INN[]',array('value'=>$Statsfielding->INN,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fINN$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'DP[]',array('value'=>$Statsfielding->DP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fDP$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'SB[]',array('value'=>$Statsfielding->SB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fSB$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'CS[]',array('value'=>$Statsfielding->CS,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fCS$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'PB[]',array('value'=>$Statsfielding->PB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fPB$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'C_WP[]',array('value'=>$Statsfielding->C_WP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fC_WP$player->idplayer"));
				echo $form->hiddenfield($Statsfielding,'GS[]',array('value'=>$Statsfielding->GS,'class'=>'inputnumbers','maxsize'=>2,"id"=>"fGS$player->idplayer"));


				switch ($Batters[$i]->DefensePosition){

					case 1: //Pitcher
						$str = "'P: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						Yii::app()->user->setState('pitcher',$player->idplayer);
						echo "<script  type='text/javascript'> var pitcher=$player->idplayer </script>";
						echo "<script  type='text/javascript'> pitcherDefensive=$str;</script>";

						break;
					case 2: //catcher
						Yii::app()->user->setState('catcher',$player->idplayer);
						echo "<script  type='text/javascript'> var catcher=$player->idplayer </script>";
						$str = "'C: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						echo "<script  type='text/javascript'> catcherDefensive=$str;</script>";
						break;
					case 3: //base1
						$str = "'B1: # ".$Batters[$i]->Number." ".$player->Firstname."'";

						Yii::app()->user->setState('base1',$player->idplayer);
						echo "<script  type='text/javascript'> v1bDefensive=$str;</script>";
						echo "<script  type='text/javascript'> var base1=$player->idplayer </script>";
						break;
					case 4: //base2
						$str = "'B2: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						echo "<script  type='text/javascript'> v2bDefensive=$str;</script>";
						Yii::app()->user->setState('base2',$player->idplayer);
						echo "<script  type='text/javascript'> var base2=$player->idplayer </script>";
						break;
					case 5: //base3
						$str = "'B3: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						echo "<script  type='text/javascript'> v3bDefensive=$str;</script>";
						Yii::app()->user->setState('base3',$player->idplayer);
						echo "<script  type='text/javascript'> var base3=$player->idplayer </script>";
						break;
					case 6: //shortstop
						$str = "'SS: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						echo "<script  type='text/javascript'> ssDefensive=$str;</script>";
						Yii::app()->user->setState('shortstop',$player->idplayer);
						echo "<script  type='text/javascript'> var shortstop=$player->idplayer </script>";
						break;
					case 7: //leftfield
						$str = "'LF: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						echo "<script  type='text/javascript'> lfDefensive=$str;</script>";
						Yii::app()->user->setState('leftfield',$player->idplayer);
						echo "<script  type='text/javascript'> var leftfield=$player->idplayer </script>";
						break;
					case 8: //centerfield
						$str = "'CF: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						echo "<script  type='text/javascript'> cfDefensive=$str;</script>";
						Yii::app()->user->setState('centerfield',$player->idplayer);
						echo "<script  type='text/javascript'> var centerfield=$player->idplayer </script>";
						break;
					case 9: //rightfield
						$str = "'RF: # ".$Batters[$i]->Number." ".$player->Firstname."'";
						echo "<script  type='text/javascript'> rfDefensive=$str;</script>";
						Yii::app()->user->setState('rightfield',$player->idplayer);
						echo "<script  type='text/javascript'> var rightfield=$player->idplayer </script>";
						break;
					case 10: //EF
						break;
					case 11: //Designatedhitter
						Yii::app()->user->setState('designatedhitter',$player->idplayer);
						echo "<script  type='text/javascript'> var designatedhitter=$player->idplayer </script>";
						break;
					case 12: //PH pinch hitter
						Yii::app()->user->setState('pinchhitter',$player->idplayer);
						echo "<script  type='text/javascript'> var pinchhitter=$player->idplayer </script>";
						break;
					case 13: //PR pinch runner
						Yii::app()->user->setState('pinchrunner',$player->idplayer);
						echo "<script  type='text/javascript'> var pinchrunner=$player->idplayer </script>";
						break;
					case 14: //CR
						break;
					case 15: //EH
						break;
					case 16: //X
						break;
				}
			}

			$e=0;
			//Search the player stats
			if ($count_stats_hit){
				for ($e;$e < $count_stats_hit; $e++){

					if ($StatshittingArray[$e]->Players_idplayer == $player->idplayer){

						$Statshitting =  $StatshittingArray[$e];
						echo $form->hiddenfield($Statshitting,'idstatshit[]',array('value'=>$StatshittingArray[$e]->idstatshit));
						$e = $count_stats_hit;
					}
				}
			}

			if($Batters[$i]->DefensePosition != "1"){

			echo "<tr>
			<td colspan=3 class='$class'>".$Batters[$i]->Number." ".$player->Firstname . ' ' . $player->Lastname[0]. " - ". $positions[$Batters[$i]->DefensePosition-1]. "</td>";

			if (! $Statshitting->AB) $Statshitting->AB = 0;
			if (! $Statshitting->H) $Statshitting->H = 0;
			if (! $Statshitting->RBI) $Statshitting->RBI = 0;
			if (! $Statshitting->BB) $Statshitting->BB = 0;
			if (! $Statshitting->SO) $Statshitting->SO = 0;

			if (! $Statshitting->PA) $Statshitting->PA = 0;
			if (! $Statshitting->R) $Statshitting->R = 0;
			if (! $Statshitting->v2B) $Statshitting->v2B = 0;
			if (! $Statshitting->v3B) $Statshitting->v3B = 0;
			if (! $Statshitting->HR) $Statshitting->HR = 0;
			if (! $Statshitting->TB) $Statshitting->TB = 0;
			if (! $Statshitting->IBB) $Statshitting->IBB = 0;
			if (! $Statshitting->HP) $Statshitting->HP = 0;
			if (! $Statshitting->SH) $Statshitting->SH = 0;
			if (! $Statshitting->SF) $Statshitting->SF = 0;
			if (! $Statshitting->SB) $Statshitting->SB = 0;
			if (! $Statshitting->CS) $Statshitting->CS = 0;
			if (! $Statshitting->LOB) $Statshitting->LOB = 0;
			if (! $Statshitting->OE) $Statshitting->OE = 0;
			if (! $Statshitting->FC) $Statshitting->FC = 0;
			if (! $Statshitting->CO) $Statshitting->CO = 0;
			if (! $Statshitting->DP) $Statshitting->DP = 0;
			if (! $Statshitting->TP) $Statshitting->TP = 0;
			if (! $Statshitting->OBP) $Statshitting->OBP = 0;
			if (! $Statshitting->SLG) $Statshitting->SLG = 0;
			if (! $Statshitting->AVG) $Statshitting->AVG = 0;

			echo "<td class='$class'>".$form->textfield($Statshitting,'AB[]',array("readonly"=>'true','value'=>$Statshitting->AB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"AB$player->idplayer"))."</td>";
			echo "<td class='$class'>".$form->textfield($Statshitting,'H[]',array("readonly"=>'true','value'=>$Statshitting->H,'class'=>'inputnumbers','maxsize'=>2,"id"=>"H$player->idplayer"))."</td>";
			echo "<td class='$class'>".$form->textfield($Statshitting,'RBI[]',array("readonly"=>'true','value'=>$Statshitting->RBI,'class'=>'inputnumbers','maxsize'=>2,"id"=>"RBI$player->idplayer"))."</td>";
			echo "<td class='$class'>".$form->textfield($Statshitting,'BB[]',array("readonly"=>'true','value'=>$Statshitting->BB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"BB$player->idplayer"))."</td>";
			echo "<td class='$class'>".$form->textfield($Statshitting,'SO[]',array("readonly"=>'true','value'=>$Statshitting->SO,'class'=>'inputnumbers','maxsize'=>2,"id"=>"SO$player->idplayer"))."</td>";

			echo $form->hiddenfield($Statshitting,'PA[]',array('value'=>$Statshitting->PA,'class'=>'inputnumbers','maxsize'=>2,"id"=>"PA$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'R[]',array('value'=>$Statshitting->R,'class'=>'inputnumbers','maxsize'=>2,"id"=>"R$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'v2B[]',array('value'=>$Statshitting->v2B,'class'=>'inputnumbers','maxsize'=>2,"id"=>"v2B$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'v3B[]',array('value'=>$Statshitting->v3B,'class'=>'inputnumbers','maxsize'=>2,"id"=>"v3B$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'HR[]',array('value'=>$Statshitting->HR,'class'=>'inputnumbers','maxsize'=>2,"id"=>"HR$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'TB[]',array('value'=>$Statshitting->TB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"TB$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'IBB[]',array('value'=>$Statshitting->IBB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"IBB$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'HP[]',array('value'=>$Statshitting->HP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"HP$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'HBP[]',array('value'=>$Statshitting->HBP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"HBP$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'SH[]',array('value'=>$Statshitting->SH,'class'=>'inputnumbers','maxsize'=>2,"id"=>"SH$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'SF[]',array('value'=>$Statshitting->SF,'class'=>'inputnumbers','maxsize'=>2,"id"=>"SF$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'SB[]',array('value'=>$Statshitting->SB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"SB$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'CS[]',array('value'=>$Statshitting->CS,'class'=>'inputnumbers','maxsize'=>2,"id"=>"CS$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'LOB[]',array('value'=>$Statshitting->LOB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"LOB$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'OE[]',array('value'=>$Statshitting->OE,'class'=>'inputnumbers','maxsize'=>2,"id"=>"OE$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'FC[]',array('value'=>$Statshitting->FC,'class'=>'inputnumbers','maxsize'=>2,"id"=>"FC$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'CO[]',array('value'=>$Statshitting->CO,'class'=>'inputnumbers','maxsize'=>2,"id"=>"CO$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'DP[]',array('value'=>$Statshitting->DP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"DP$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'TP[]',array('value'=>$Statshitting->TP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"TP$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'OBP[]',array('value'=>$Statshitting->OBP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"OBP$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'SLG[]',array('value'=>$Statshitting->SLG,'class'=>'inputnumbers','maxsize'=>2,"id"=>"SLG$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'AVG[]',array('value'=>$Statshitting->AVG,'class'=>'inputnumbers','maxsize'=>2,"id"=>"AVG$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'SAC[]',array('value'=>$Statshitting->SAC,'class'=>'inputnumbers','maxsize'=>2,"id"=>"SAC$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'GDP[]',array('value'=>$Statshitting->GDP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"GDP$player->idplayer"));
			echo $form->hiddenfield($Statshitting,'XBH[]',array('value'=>$Statshitting->XBH,'class'=>'inputnumbers','maxsize'=>2,"id"=>"XBH$player->idplayer"));

			echo $form->hiddenfield($Statshitting,'Players_idplayer[]',array('value'=>$player->idplayer));
			echo $form->hiddenfield($Statshitting,'Games_idgame[]',array('value'=>$idgame));

			if ( Yii::app()->user->getState('battingteam') == $teamid)
				if ( Yii::app()->user->getState('batterNumber') == $i+1){
					echo "<script> $('#span-23').html( $('#span-23').html() + ' ( $Statshitting->H of $Statshitting->AB )') </script>";
				}
			echo "</tr>";
			}
		}



	echo "<tr class='trdiv'></tr>";
	echo "<tr>";
		echo "<td class='blacktitle' colspan=8> PITCHING STAT </td>";
	echo "</tr>";
	echo "<tr class='greentr'>";
		echo "<td width='30%'> Pitcher </td> <td>IP</td> <td>H</td> <td>R</td> <td>BB</td> <td>SO</td>  <td>B</td>  <td>S</td>";
	echo "</tr>";

	//Load stats of players
	$criteria = new CDbCriteria();
	$criteria->addcondition("Games_idgame=$idgame");
	$Statspitching = new Statspitching;
	$StatspitchingArray = Statspitching::model()->findAll($criteria);

	$count_stats_pit = count ($StatspitchingArray);

		for ($o=0;$o < count($pitcher); $o++){
			$class = "grayatbat";
			//Select from pitcher's array
			$i = $pitcher[$o];
			$player=Players::model()->findByPk($Batters[$i]->Players_idplayer); //CAMBIAR LIST de USUARIOS


				$e=0;
				//Search the pitcher stats
				if ($count_stats_pit){
					for ($e;$e < $count_stats_pit; $e++){
						if ($StatspitchingArray[$e]->Players_idplayer == $player->idplayer){


							$Statspitching =  $StatspitchingArray[$e];
							echo $form->hiddenfield($Statspitching,'idstatspit[]',array('value'=>$StatspitchingArray[$e]->idstatspit));
							$e = $count_stats_pit;
						}
					}
				}


				echo "<tr>
				<td 	 class='$class'>".$Batters[$i]->Number." ".$player->Firstname ." ".$player->Lastname[0].  "</td>";


				//Games started as the pitcher

				if (Yii::app()->user->getState('inning') == 1) {
					$Statspitching->GS = 1;
				}else
					$Statspitching->GS = 0;

				//The total number of games in which the pitcher appeared, whether as the starter or as a reliever.
				if (! $Statspitching->G) $Statspitching->G = 1;


				echo "<td class='$class'>".$form->textfield($Statspitching,'IP[]',array("readonly"=>'true','value'=>$Statspitching->IP,'class'=>'inputnumbers','maxsize'=>2,"id"=>"pIP$player->idplayer"))."</td>";
				echo "<td class='$class'>".$form->textfield($Statspitching,'H[]',array("readonly"=>'true','value'=>$Statspitching->H,'class'=>'inputnumbers','maxsize'=>2,"id"=>"pH$player->idplayer"))."</td>";
				echo "<td class='$class'>".$form->textfield($Statspitching,'R[]',array("readonly"=>'true','value'=>$Statspitching->R,'class'=>'inputnumbers','maxsize'=>2,"id"=>"pR$player->idplayer"))."</td>";
				echo "<td class='$class'>".$form->textfield($Statspitching,'BB[]',array("readonly"=>'true','value'=>$Statspitching->BB,'class'=>'inputnumbers','maxsize'=>2,"id"=>"pBB$player->idplayer"))."</td>";
				echo "<td class='$class'>".$form->textfield($Statspitching,'SO[]',array("readonly"=>'true','value'=>$Statspitching->SO,'class'=>'inputnumbers','maxsize'=>2,"id"=>"pSO$player->idplayer"))."</td>";
				echo "<td class='$class'>".$form->textfield($Statspitching,'B[]',array("readonly"=>'true','value'=>$Statspitching->B,'class'=>'inputnumbers','maxsize'=>2,"id"=>"pB$player->idplayer"))."</td>";
				echo "<td class='$class'>".$form->textfield($Statspitching,'S[]',array("readonly"=>'true','value'=>$Statspitching->S,'class'=>'inputnumbers','maxsize'=>2,"id"=>"pS$player->idplayer"))."</td>";

				echo $form->hiddenfield($Statspitching,'BF[]',array('value'=>$Statspitching->BF,"id"=>"pBF$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'ER[]',array('value'=>$Statspitching->ER,"id"=>"pER$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'v2B[]',array('value'=>$Statspitching->v2B,"id"=>"pv2B$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'v3B[]',array('value'=>$Statspitching->v3B,"id"=>"pv3B$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'HR[]',array('value'=>$Statspitching->HR,"id"=>"pHR$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'SH[]',array('value'=>$Statspitching->SH,"id"=>"pSH$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'SF[]',array('value'=>$Statspitching->SF,"id"=>"pSF$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'HBP[]',array('value'=>$Statspitching->HBP,"id"=>"pHBP$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'HB[]',array('value'=>$Statspitching->HB,"id"=>"pHB$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'WP[]',array('value'=>$Statspitching->WP,"id"=>"pWP$player->idplayer"));
				//echo $form->hiddenfield($Statspitching,'CO[]',array('value'=>$Statspitching->CO,"id"=>"pCO$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'BK[]',array('value'=>$Statspitching->BK,"id"=>"pBK$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'G[]',array('value'=>$Statspitching->G,"id"=>"pG$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'GS[]',array('value'=>$Statspitching->GS,"id"=>"pGS$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'CG[]',array('value'=>$Statspitching->CG,"id"=>"pCG$player->idplayer"));
				//echo $form->hiddenfield($Statspitching,'CGL[]',array('value'=>$Statspitching->CGL,"id"=>"pCGL$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'W[]',array('value'=>$Statspitching->W,"id"=>"pW$player->idplayer"));
				//echo $form->hiddenfield($Statspitching,'LS[]',array('value'=>$Statspitching->LS,"id"=>"pLS$player->idplayer"));
				//echo $form->hiddenfield($Statspitching,'HO[]',array('value'=>$Statspitching->HO,"id"=>"pHO$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'SV[]',array('value'=>$Statspitching->SV,"id"=>"pSV$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'AB[]',array('value'=>$Statspitching->AB,"id"=>"pAB$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'CS[]',array('value'=>$Statspitching->CS,"id"=>"pCS$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'SB[]',array('value'=>$Statspitching->SB,"id"=>"pSB$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'NP[]',array('value'=>$Statspitching->NP,"id"=>"pNP$player->idplayer"));
				echo $form->hiddenfield($Statspitching,'GIDP[]',array('value'=>$Statspitching->GIDP,"id"=>"pGIDP$player->idplayer"));

				echo $form->hiddenfield($Statspitching,'Players_idplayer[]',array('value'=>$player->idplayer));
				echo $form->hiddenfield($Statspitching,'Games_idgame[]',array('value'=>$idgame));
				echo "</tr>";

		}

	echo "</tr>";
				
}

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
)); ?>
	
	<?php echo $form->hiddenfield($model,'turntobat'); ?>
	<?php echo $form->error($model,'turntobat'); ?>
	
	<?php echo $form->hiddenfield($model,'play'); ?>
	<?php echo $form->error($model,'play'); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="tableHome">
	
	<table >
		
		<tr>
			
			<td class="tdUpper">
				
	

    
   
    </p>
			<? $gameid = Yii::app()->user->getState('idgame'); ?>
			<table class="tablevisiting">
				
				<?
				//if (! Yii::app()->user->getState('idlineupvisiting')){
					$criteria = new CDbCriteria();
					$idteam =  Yii::app()->user->getState('idteamvisiting');
					$criteria->addcondition("Games_idgame=$gameid AND Teams_idteam=$idteam");
					
					$lineup = new Lineup;
					$lineup = Lineup::model()->findAll($criteria);
					Yii::app()->user->setState('idlineupvisiting', $lineup[0]['idlineup']);
					
					if (! Yii::app()->user->getState('idlineupvisiting')) Yii::app()->user->setState('idlineupvisiting', 0);
					
				//}
				
				loadTableTeam(Yii::app()->user->getState('idlineupvisiting'),$form,$model);
				?>


			</table>
	
			<table class="tablehome">
				
				
				<?
				
				
				if (! Yii::app()->user->getState('idlineuphome')){
					$criteria = new CDbCriteria();
					$idteam =  Yii::app()->user->getState('idteamhome');
					$criteria->addcondition("Games_idgame=$gameid AND Teams_idteam=$idteam");
					
					$lineup = new Lineup;
					$lineup = Lineup::model()->findAll($criteria);
					Yii::app()->user->setState('idlineuphome', $lineup[0]['idlineup']);
				}

				loadTableTeam(Yii::app()->user->getState('idlineuphome'),$form,$model);
				?>
				
				
				
			</table>
				
		
				
			</td>
			
			<td style="padding-left: 10px;">	
				<div class="comments">
				
				<table>
					<tr>
					<td class='darkgreentr'>
						<?php echo "At Bat History"; ?>
					</td>
					<td class='darkgreentr'>
						<?php echo "Comments"; ?>
					</tr>
					
					<tr class='greentr'>
						<td ><?php echo $form->textarea($model,'Comment'); ?>
						<?php echo $form->error($model,'comments'); ?>
						</td> 
						<td><?php echo $form->textarea($model,'Comment'); ?>
						<?php echo $form->error($model,'comments'); ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
							<div class="HR">
							
							</div>
							
							<table >
								<tr id="trballtrayectory" style="display:none">
									<td align="center" colspan=18	><?php echo CHtml::label("","",array('style'=>'display: inline-table;','id'=>"textaction",'width'=>'40px')) ?>
									<?php echo CHtml::button('Undo Hit Location', array('onclick' => "undoEvent('balltrayectory')", "disabled" => "true", "id"=>"balltrayectorybutton")); ?>
									<?php echo CHtml::button('Cancel', array('onclick' => "cancelBallTrayectory()")); ?> </td>
								</tr>
								<tr>
									
									<td colspan=8 style="text-align: left" >
									<canvas id="myDrawing" width="510" height="400" disabled="true"  >
										
									<!-- style="background-image:url('images/field.png'); background-repeat: no-repeat; background-position:center" -->
									<p>Your browser doesn't support canvas.</p>
									</canvas>	
									<br>
									
									</td> 
									<td width="5%" style="margin-bottom: 0px; vertical-align: bottom">
										<table style="margin-bottom: 0px; vertical-align: bottom">
											<tr></tr><td id=HR> <?php echo CHtml::image('images/button_hr.png','',array('id'=>'buttonHR',"onClick"=>'fillhr(1)')); ?> </td> </tr>
											<tr></tr><td id=3B> <?php echo CHtml::image('images/button_3b.png','',array('id'=>'button3B',"onClick"=>'fill3b(1)')); ?> </td> </tr>
											<tr></tr><td id=2B> <?php echo CHtml::image('images/button_2b.png','',array('id'=>'button2B',"onClick"=>'fill2b(1)')); ?> </td> </tr>
											<tr></tr><td id=1B> <?php echo CHtml::image('images/button_1b.png','',array('id'=>'button1B',"onClick"=>'fill1b(1)')); ?> </td> </tr>
											<tr></tr><td id=BB> <?php echo CHtml::image('images/button_bb.png','',array('id'=>'buttonBB',"onClick"=>'fillbb(1)')); ?></td> </tr>
											<tr></tr><td id=HP> <?php echo CHtml::image('images/button_hp.png','',array('id'=>'buttonHP',"onClick"=>'fillhp(1)')); ?> </td> </tr>
											<tr></tr><td id=balltrayectory> <?php echo CHtml::image('images/button_balltray.png','',array('id'=>'balltray',"onClick"=>'enableBallTray()')); ?> </td> </tr>
											<tr></tr><td id=*> <?php echo CHtml::image('images/button_defense.png','',array('id'=>'defense',"onClick"=>'defenseLineup()')); ?> </td> </tr>
										</table>
										
									</td>
								</tr>
								<tr style="text-align: right;">
									<td style="text-align: left;height: 20px;" class="logo" rowspan="4">
										<div style='height:10px;'>
											<? printLogo(Yii::app()->user->getState('battingteam') )  ?>  
										</div>  
										
									</td>
									<td class="logo"> </td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_k.png','',array('id'=>'K')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_fc.png','',array('id'=>'FC')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_dp.png','',array('id'=>'DP')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_sac.png','',array('id'=>'SAC')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_misc.png','',array('id'=>'Misc')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_batter.png','',array('id'=>'batter')); ?></td>
									<td width=5% style='white-space: nowrap; margin: -10px !important'><?php echo CHtml::image('images/button_nextbatter.png','',array('id'=>'nextbatter','onClick'=>'if(!$(".brownatbat").removeClass("brownatbat").addClass("grayatbat").parent().next().find("td").removeClass("grayatbat").addClass("brownatbat").length){
   $(".tablevisiting").find(".grayatbat:first").parent().find("td").addClass("brownatbat").removeClass("grayatbat");
   if(twotime){
       $(".tablevisiting").find(".grayatbat:first").parent().find("td").addClass("brownatbat").removeClass("grayatbat");
        $(".tablevisiting").find(".brownatbat:first").parent().find("td").removeClass("brownatbat").addClass("grayatbat");
   }
   twotime = true;
}else{
   twotime = false;
}/*submitLink("atbata")*/' )); ?></td>
									
								</tr>
																		
							</table>
					
							<table class="FoulBalls">
								<tr >
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('6',1)",'style'=>'border:0px;','class'=>'B4_gray',"id"=>"ball6Button",'disabled'=>true)); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('4',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball4Button")); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('5',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball5Button")); ?></td>
								</tr>
								<tr>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('1',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball1Button")); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('2',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball2Button")); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('3',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball3Button")); ?></td>
								</tr>
								
							</table>
						</td>
					</tr>
					<tr>
						
						<td colspan="2">
							<table style="margin-bottom: 0em">
								<tr class="blacktitle">
									<td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td></td><td>R</td><td>H</td><td>E</td>
								</tr>
								
								<tr>
									<td class='grayatbat'><?php echo Yii::app()->user->getState('teamvisiting');?></td>
									<?
									loadTableRuns ($idgame,Yii::app()->user->getState('idteamvisiting'),$form);
									?>
								</tr>
								
								<tr>
									<td class='grayatbat'><?php echo Yii::app()->user->getState('teamhome');?></td>
									
									<?
									loadTableRuns ($idgame,Yii::app()->user->getState('idteamhome'),$form);
									?>
								</tr>
								<tr>
									<td colspan="18">
											<?php echo CHtml::button('1', array('onclick' => "clickPos1(1)",'class'=>'f1')); ?>
											<?php echo CHtml::button('2', array('onclick' => "clickPos2(1)",'class'=>'f2')); ?>
											<?php echo CHtml::button('3', array('onclick' => "clickPos3(1)",'class'=>'f3')); ?>
											<?php echo CHtml::button('4', array('onclick' => "clickPos4(1)",'class'=>'f4')); ?>
											<?php echo CHtml::button('5', array('onclick' => "clickPos5(1)",'class'=>'f5')); ?>
											<?php echo CHtml::button('6', array('onclick' => "clickPos6(1)",'class'=>'f6')); ?>
											<?php echo CHtml::button('7', array('onclick' => "clickPos7(1)",'class'=>'f7')); ?>
											<?php echo CHtml::button('8', array('onclick' => "clickPos8(1)",'class'=>'f8')); ?>
											<?php echo CHtml::button('9', array('onclick' => "clickPos9(1)",'class'=>'f9')); ?>
											<?php echo CHtml::button('', array('onclick' => "RBItext()",'class'=>'RBI',"id"=>"RBI","value"=>'RBI')); ?>
											<?php echo CHtml::button('', array('onclick' => "ERtext()",'class'=>'ER',"id"=>"ER", "value"=>"ER")); ?>
											<?php echo CHtml::button('', array('class'=>'T1',"id"=>"T1")); ?>
											<?php echo CHtml::textfield('B1text','', array('onclick' => "B1text()",'class'=>'B1',"id"=>"B1")); ?>
											<?php echo CHtml::textfield('B2text','', array('onclick' => "B2text()",'class'=>'B2',"id"=>"B2")); ?>
											<?php echo CHtml::textfield('B3text','', array('onclick' => "B3text()",'class'=>'B3',"id"=>"B3")); ?>
											<?php echo CHtml::textfield('B4text','', array('onclick' => "B4text()",'class'=>'iB4',"id"=>"B4")); ?>
											<?php echo CHtml::button('', array('class'=>'OutNumber',"id"=>"OutNumber", "value"=>$Outs+1)); ?>
											<?php echo CHtml::textfield('OutText','', array('onclick' => "Outtext()",'class'=>'OutText',"id"=>"OutText")); ?>
											<?php echo CHtml::button('', array('class'=>'base1button',"id"=>"base1button")); ?>
											<?php echo CHtml::button('', array('class'=>'base2button',"id"=>"base2button")); ?>
											<?php echo CHtml::button('', array('class'=>'base3button',"id"=>"base3button")); ?>
											<?php echo CHtml::button('', array('class'=>'base4button',"id"=>"base4button")); ?>
											
									</td>
									
								</tr>
							</table>
						</td>
					</tr>
				</table>		
					
				</div>
			</td>
		</tr>
		
	</table>
	

		
	
		<?php echo $form->hiddenfield($model,'Lineup_idlineup'); ?>
		<?php echo $form->error($model,'Lineup_idlineup'); ?>
		
	<div id="rowevents">
		<?php echo $form->hiddenfield($model,'idevents[]'); ?>
		<?php echo $form->error($model,'idevents'); ?>
		
		<?php echo $form->hiddenfield($model,'Batter[]'); ?>
		<?php echo $form->error($model,'Batter'); ?>
	
		<?php echo $form->hiddenfield($model,'Misce[]'); ?>
		<?php echo $form->error($model,'Misce'); ?>
		
		<?php echo $form->hiddenfield($model,'Events_type_idevents_type[]'); ?>
		<?php echo $form->error($model,'Events_type_idevents_type'); ?>

		<?php echo $form->hiddenfield($model,'text[]'); ?>
		<?php echo $form->error($model,'text'); ?>
		
		<?php echo $form->hiddenfield($model,'RBI[]'); ?>
		<?php echo $form->error($model,'RBI'); ?>
		
		<?php echo $form->hiddenfield($model,'ER[]'); ?>
		<?php echo $form->error($model,'ER'); ?>
		
		<?php echo $form->hiddenfield($model,'playerid[]'); ?>
		<?php echo $form->error($model,'playerid'); ?>
		
		<?php echo $form->hiddenfield($model,'batterNumberOut[]'); ?>
		<?php echo $form->error($model,'batterNumberOut'); ?>
		
		<?php echo $form->hiddenfield($model,'b1[]'); ?>
		<?php echo $form->hiddenfield($model,'b2[]'); ?>
		<?php echo $form->hiddenfield($model,'b3[]'); ?>
	</div>
	
		<?php echo $form->hiddenfield($model,'Inning'); ?>
		<?php echo $form->error($model,'Inning'); ?>
		

		
		<?php echo CHtml::hiddenField('hitterBase1',$hitterBase1,array("id"=>"hitterBase1")); ?>
		<?php echo CHtml::hiddenField('hitterBase2',$hitterBase2,array("id"=>"hitterBase2")); ?>
		<?php echo CHtml::hiddenField('hitterBase3',$hitterBase3,array("id"=>"hitterBase3")); ?>
		<?php echo CHtml::hiddenField('ballx','',array("id"=>"ballx")); ?>
		<?php echo CHtml::hiddenField('bally','',array("id"=>"bally")); ?>
		
						
	
	<?
	echo CHtml::hiddenField('link','',array('id'=>'link'));
	?>

	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</div>

<script>
	
var drawingCanvas = document.getElementById('myDrawing');


// Check the element is in the DOM and the browser supports canvas
if(drawingCanvas.getContext) {
// Initaliase a 2-dimensional drawing context
	var basecanvas = drawingCanvas.getContext('2d');
//Canvas commands go here
}

basecanvas.beginPath();

function printBases(){
	basecanvas.save();
	basecanvas.restore();
	
	// Create the yellow face
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";
	
	//1B
	basecanvas.beginPath();
	basecanvas.moveTo(345,180);
	basecanvas.lineTo(355,185); // \
	basecanvas.lineTo(365,180); //  /
	basecanvas.lineTo(355,175); //  \
	basecanvas.lineTo(345,180); // /
	basecanvas.stroke();
	
	//2B
	basecanvas.beginPath();
	basecanvas.moveTo(242,152);
	basecanvas.lineTo(252,157); // \
	basecanvas.lineTo(262,152); //  /
	basecanvas.lineTo(252,147); //  \
	basecanvas.lineTo(242,152); // /
	basecanvas.stroke();
	
	//3B
	basecanvas.beginPath();
	basecanvas.moveTo(140,180);
	basecanvas.lineTo(150,185); // \
	basecanvas.lineTo(160,180); //  /
	basecanvas.lineTo(150,175); //  \
	basecanvas.lineTo(140,180); // /
	basecanvas.stroke();
	
	//PLATE
	basecanvas.beginPath();
	basecanvas.moveTo(242,230);
	basecanvas.lineTo(252,235); // \
	basecanvas.lineTo(262,230); //  /
	basecanvas.lineTo(262,225); // |
	basecanvas.lineTo(242,225); // |
	basecanvas.lineTo(242,230); // 
	basecanvas.stroke();
	
	basecanvas.save();
}


function InitBases(){
	
	if (! idevents) {
	 	if (hitterBase1){
			b1();
			$('#base1button').attr('onclick', 'baseButtonUndo('+eventscounter+')');
			} 
		else {
			$('#base1button').attr('onclick', 'fill1b(1)');
		}
		
		
		if (hitterBase2) b2();
		else {
			if (hitterBase1){ //Stolen base functions
				$('#base2button').attr('id', 'baseFunctionb2'); 
			}else{
				$('#base2button').attr('onclick', 'fill2b(1)'); //Button to Base2
			}
		}
		
		
		if (hitterBase3) {
			b3();
			$('#base4button').attr('id', 'baseFunctionb4'); 
		}
		else{
			if (hitterBase2){ //Stolen base functions
				$('#base3button').attr('id', 'baseFunctionb3'); 
			}else{
				if (!hitterBase2 && !hitterBase1 )
				$('#base3button').attr('onclick', 'fill3b(1)');
			}
		}
 	}	
	
}

function initEvent(){
	//If we're updating and event
if (idevents){
	
}
}
</script>

<?php 

 //$str1=loadEvents(1300);

if (!empty($str1)) {
	echo Yii::trace(CVarDumper::dumpAsString($str1), 'salida');
}
 
$str = "<script>
basecanvas.beginPath();
var imageObj = new Image();
imageObj.onload = function() {
	basecanvas.drawImage(imageObj, -2, 85);
	printBases();
	InitBases();
	initEvent();
	";
	
if ( $model->idevents ) {
	$str .= loadEvents( $model->idevents );
}
	
  
  
$str.="
	idevents = 0;
	}
imageObj.src = 'images/Field.png';
basecanvas.stroke();
basecanvas.closePath();
basecanvas.beginPath();
basecanvas.globalCompositeOperation = 'source-over';


</script>";

echo $str;
?>

<script>




//Mouse position function

var canvasOffset=$("#myDrawing").offset();
    var offsetX=canvasOffset.left;
    var offsetY=canvasOffset.top;

function getPosition(event)
      {
        var x = new Number();
        var y = new Number();
        var drawingCanvas = document.getElementById("myDrawing");
		

	 	var totalOffsetX = 0;
	    var totalOffsetY = 0;
	    var canvasX = 0;
	    var canvasY = 0;
	    var currentElement = this;
	
	    do {
	        totalOffsetX += currentElement.offsetLeft;
	        totalOffsetY += currentElement.offsetTop;
	    }
	    while (currentElement = currentElement.offsetParent)
	
	    canvasX = event.pageX - totalOffsetX;
	    canvasY = event.pageY - totalOffsetY;
	
	    // Fix for variable canvas width
	    x = Math.round( canvasX * (this.width / this.offsetWidth) );
	    y = Math.round( canvasY * (this.height / this.offsetHeight) );
   
        
        fillballtray(x,y);
		
        document.getElementById("balltrayectorybutton").disabled = false;
        drawingCanvas.removeEventListener("mousedown", getPosition, false);
        document.getElementById("trballtrayectory").style.display = 'none';
      }
  
function enableBallTray (){
	var drawingCanvas = document.getElementById("myDrawing");
	drawingCanvas.addEventListener("mousedown", getPosition, false);	
	
	
	var texta = document.getElementById("textaction"); 
	texta.innerHTML = "Touch to place hit location";
	var trball = document.getElementById("trballtrayectory");
	trball.style.display = '';
	
}

function cancelBallTrayectory(){
	document.getElementById("trballtrayectory").style.display = 'none';
	document.getElementById("balltrayectorybutton").disabled = false;
    drawingCanvas.removeEventListener("mousedown", getPosition, false);   
}



function drawEvent(){
	//If we're updating and event
	//alert("DrawEvent");
if (idevents){
	//alert(idevents);
	//Recreate the event
	switch (Events_type_idevents_type) {
			
			case 1:
				fillplate();
			break;
			case 2: //3B
				fill3b(0);
			break;
			
			case 3: //2B
				fill2b(0);
			break;
			
			case 4: //1B
				
				fill1b(0) ;
			break;
			
			case 5: 
				fillbb(0) ;
			break;
			case 6 : //BB HP
				
				
			break;
			
			
			case 37:  //Event is out
				out(1);
				
			break;
			
			case 40:
				fill2b(0);
			break;
			
			case 41:
				fill3b(0);
			break;
			
			case 42:
				fillplate(0);
			break;
			
			
		}
	
}
}


</script>

<div id='defensivefield' style="position:absolute;left:-2000px;top:-250px; ">
  <div class='defensivefield' >	
	<div class='blacktitle' style='width:auto !important' > DEFENSIVE LINEUP / <? echo Yii::app()->user->getState('$defensiveteam') ?> </div>
	<img src="images/defensivefield.png">
	<div class='defensiveBrownTitle'> <? echo Yii::app()->user->getState('$defensiveteam') ?> BASIC PITCHING STATS </div>
	<div onclick="HideDefensive()" class="redDefensiveButton"> DONE  </div>
  </div>
	<div id='defensivecatcher' class='defensivePlayerTag' style='position: absolute;left:95px;top:330px;'></div>
	<div id='defensivepitcher' class='defensivePlayerTag' style='position: absolute;left:95px;top:232px;'></div>	
	<div id='defensive1b' class='defensivePlayerTag' style='position: absolute;left:184px;top:189px;'></div>	
	<div id='defensive2b' class='defensivePlayerTag' style='position: absolute;left:184px;top:127px;'></div>
	<div id='defensive3b' class='defensivePlayerTag' style='position: absolute;left:10px;top:189px;'></div>
	<div id='defensivess' class='defensivePlayerTag' style='position: absolute;left:10px;top:127px;'></div>	
	<div id='defensivelf' class='defensivePlayerTag' style='position: absolute;left:10px;top:80px;'></div>	
	<div id='defensivecf' class='defensivePlayerTag' style='position: absolute;left:95px;top:45px;'></div>
	<div id='defensiverf' class='defensivePlayerTag' style='position: absolute;left:184px;top:80px;'></div>		
  
</div>

<div id='wizardfield' style="position:absolute;left:-2000px;top:-250px; ">
  <div class='defensivefield' >	
	<div class='blacktitle' style='width:auto !important' >WIZARD / <? echo Yii::app()->user->getState('$defensiveteam') ?> </div>
	<img src="images/defensivefield.png">
	<div class='defensiveBrownTitle'> Select the players involved </div>
	<div onclick="HideWizard()" id='HideWizardbutton' class="redDefensiveButton"> DONE  </div>
  </div>
	<div id='defensivecatcher' class='wizardPlayerTag' onclick="out(2,1)" style='position: relative;left:145px;top:-100px;'>2</div>
	<div id='defensivepitcher' class='wizardPlayerTag' onclick="out(1,1)" style='position: relative;left:145px;top:-230px;'>1</div>	
	<div id='defensive1b' class='wizardPlayerTag' onclick="out(3,1)" style='position: relative;left:235px;top:-285px;'>3</div>	
	<div id='defensive2b' class='wizardPlayerTag' onclick="out(4,1)" style='position: relative;left:220px;top:-370px;'>4</div>
	<div id='defensive3b' class='wizardPlayerTag' onclick="out(5,1)" style='position: relative;left:60px;top:-337px;'>5</div>
	<div id='defensivess' class='wizardPlayerTag' onclick="out(6,1)" style='position: relative;left:90px;top:-420px;'>6</div>	
	<div id='defensivelf' class='wizardPlayerTag' onclick="out(7,1)" style='position: relative;left:55px;top:-480px;'>7</div>	
	<div id='defensivecf' class='wizardPlayerTag' onclick="out(8,1)" style='position: relative;left:145px;top:-540px;'>8</div>
	<div id='defensiverf' class='wizardPlayerTag' onclick="out(9,1)" style='position: relative;left:255px;top:-534px;'>9</div>		  
</div>


<div id='wizardfielddp' style="position:absolute;left:-2000px;top:-250px; ">
  <div class='defensivefielddp' >	
	<div class='blacktitle' style='width:auto !important' >WIZARD / <? echo Yii::app()->user->getState('$defensiveteam') ?> </div>
	<img src="images/defensivefield.png">
	<div class='defensiveBrownTitle'> Select the players involved </div>
	<div onclick="HideWizarddp()" id='HideWizarddpbutton' class="redDefensiveButton"> DONE  </div>
  </div>
	<div id='defensivecatcher' class='wizardPlayerTag' onclick="out(2,1)" style='position: relative;left:145px;top:-100px;'>2</div>
	<div id='defensivepitcher' class='wizardPlayerTag' onclick="out(1,1)" style='position: relative;left:145px;top:-230px;'>1</div>	
	<div id='defensive1b' class='wizardPlayerTag' onclick="outdp(3)" style='position: relative;left:235px;top:-285px;'>3</div>	
	<div id='defensive2b' class='wizardPlayerTag' onclick="outdp(4)" style='position: relative;left:220px;top:-370px;'>4</div>
	<div id='defensive3b' class='wizardPlayerTag' onclick="outdp(5)" style='position: relative;left:60px;top:-337px;'>5</div>
	<div id='defensivess' class='wizardPlayerTag' onclick="outdp(6)" style='position: relative;left:90px;top:-420px;'>6</div>	
	<div id='defensivelf' class='wizardPlayerTag' onclick="outdp(7)" style='position: relative;left:55px;top:-480px;'>7</div>	
	<div id='defensivecf' class='wizardPlayerTag' onclick="outdp(8)" style='position: relative;left:145px;top:-540px;'>8</div>
	<div id='defensiverf' class='wizardPlayerTag' onclick="outdp(9)" style='position: relative;left:255px;top:-534px;'>9</div>	
	
	<div id='wdpb1' class='wizardPlayerTag' onclick="outb1('dp')" style='position: relative;left:245px;top:-400px;width:10px;height:10px'> </div>	
	<div id='wdpb2' class='wizardPlayerTag' onclick="outb2('dp')" style='position: relative;left:150px;top:-504px;width:10px;height:10px'> </div>	
	<div id='wdpb3' class='wizardPlayerTag' onclick="outb3('dp')" style='position: relative;left:55px;top:-425px;width:10px;height:10px'> </div>
		  
</div>
	
<div id='wizardfieldtp' style="position:absolute;left:-2000px;top:-250px; ">
  <div class='defensivefieldtp' >	
	<div class='blacktitle' style='width:auto !important' >WIZARD / <? echo Yii::app()->user->getState('$defensiveteam') ?> </div>
	<img src="images/defensivefield.png">
	<div class='defensiveBrownTitle'> Select the players involved </div>
	<div onclick="HideWizardtp()" id='HideWizardtpbutton' class="redDefensiveButton"> DONE  </div>
  </div>
	<div id='defensivecatcher' class='wizardPlayerTag' onclick="out(2)" style='position: relative;left:145px;top:-100px;'>2</div>
	<div id='defensivepitcher' class='wizardPlayerTag' onclick="out(1)" style='position: relative;left:145px;top:-230px;'>1</div>	
	<div id='defensive1b' class='wizardPlayerTag' onclick="outdp(3)" style='position: relative;left:235px;top:-285px;'>3</div>	
	<div id='defensive2b' class='wizardPlayerTag' onclick="outdp(4)" style='position: relative;left:220px;top:-370px;'>4</div>
	<div id='defensive3b' class='wizardPlayerTag' onclick="outdp(5)" style='position: relative;left:60px;top:-337px;'>5</div>
	<div id='defensivess' class='wizardPlayerTag' onclick="outdp(6)" style='position: relative;left:90px;top:-420px;'>6</div>	
	<div id='defensivelf' class='wizardPlayerTag' onclick="outdp(7)" style='position: relative;left:55px;top:-480px;'>7</div>	
	<div id='defensivecf' class='wizardPlayerTag' onclick="outdp(8)" style='position: relative;left:145px;top:-540px;'>8</div>
	<div id='defensiverf' class='wizardPlayerTag' onclick="outdp(9)" style='position: relative;left:255px;top:-534px;'>9</div>	
	
	<div id='wdpb1' class='wizardPlayerTag' onclick="outb1('tp')" style='position: relative;left:245px;top:-400px;width:10px;height:10px'> </div>	
	<div id='wdpb2' class='wizardPlayerTag' onclick="outb2('tp')" style='position: relative;left:150px;top:-504px;width:10px;height:10px'> </div>	
	<div id='wdpb3' class='wizardPlayerTag' onclick="outb3('tp')" style='position: relative;left:55px;top:-425px;width:10px;height:10px'> </div>
		  
</div>
<? include "contextmenus.php"; ?>


