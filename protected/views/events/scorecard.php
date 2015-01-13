<?php
/* @var $this EventsController */
/* @var $model Events */


?>


<script>
	function gotoAtBat(id){
		document.getElementById('link').value = 'events/create';
		document.getElementById('idevent').value = id;
		document.forms[0].submit();
	}	
	
	function gotoAtBatNewPlay(turntobat, inning, batter){
		document.getElementById('link').value = 'events/create';
		document.getElementById('batter').value = batter;
		document.getElementById('turntobat').value = turntobat;
		document.getElementById('inning').value = inning;
		document.forms[0].submit();
	}	
	
	
	function scoreLabelT1(text,idtd){
		
		
		//alert(id.toString());
		var t1 = document.getElementById("t1_"+idtd.id);
		
		if ( t1 ){
			id = "#t1_"+idtd.id;
			$(id).html(text);
		}else{
			var label = $('<label>').html(text);
			label.attr('id','t1_'+idtd.id);
			label.attr('style','color: #ffff00;position: relative; right:-5px;top:-5px;font-size: 6px !important; z-index:200;');
			var div = $('<div>').append(label);
			div.attr('style','width: width: 25px;position: relative; right:-5px;top:4px;');
			$(idtd).append(div)
		}
		
		//Check if there is a line tray
		/* id = "#linetray"+idtd.id;
		if ($(id).prop('id')) {
			id = "#t1_"+idtd.id;
			$(id).attr('style','color: #ffff00;position: relative; right:-5px;top:-70px;font-size: 6px !important; z-index:200;');
		}*/
			
	}
	
	function scoreLabelBall4(text,idtd){
		var label = $('<label>').text(text);
		label.attr('style','color: #ffffff;font-size: 6px !important; overflow: hidden;');
		var div = $('<div>').append(label);
		
		div.attr('style','position: absolute; right:14px;top:33px;overflow: hidden ');
		$(idtd).append(div)
	}
	
	function scoreLabelBall5(text,idtd){
		var label = $('<label>').text(text);
		label.attr('style','color: #ffffff;font-size: 6px !important; overflow: hidden;');
		var div = $('<div>').append(label);
		
		div.attr('style','position: absolute; right:4px;top:33px;overflow: hidden ');
		$(idtd).append(div)
	}
	
	function scoreLabelBall1(text,idtd){
		var label = $('<label>').text(text);
		label.attr('style','color: #ffffff;font-size: 6px !important; overflow: hidden;');
		label.attr('id','ball1_'+idtd.id);
		var div = $('<div>').append(label);
		
		
		div.attr('style','position: absolute; right:27px;top:47px;overflow: hidden ');
		$(idtd).append(div)
	}
	
	function scoreLabelBall2(text,idtd){
		
		var label = $('<label>').text(text);
		label.attr('style','color: #ffffff;font-size: 6px !important; overflow: hidden;');
		var div = $('<div>').append(label);
		
		div.attr('style','position: absolute; right:15px;top:47px;overflow: hidden; ');
		$(idtd).append(div)
		
	}
	
	function scoreLabelBall3(text,idtd){
		
		var label = $('<label>').text(text);
		label.attr('style','color: #ffffff;font-size: 6px !important; overflow: hidden;');
		var div = $('<div>').append(label);
		
		div.attr('style','position: relative; right:-28px;top:27px;overflow: hidden ');
		$(idtd).append(div)
	}
	
	function scoreLabelOut(text,idtd){
		var label = $('<label>').text("_"+text+" ");
		label.attr('class','OutNumber');
		
		id = "#linetray"+idtd.id;
		if ($(id).prop('id')) {
			id = "#t1_"+idtd.id;
			label.attr('style','background-color: transparent;color: #ffff00;position: relative; right:20px;top:22px;font-size: 6px !important; ');
		}
		
		label.attr('style','background-color: transparent;color: #ffff00;position: relative; right:20px;top:22px;font-size: 6px !important; ');
		$(idtd).append(label)
		
		
	}
	
	function scoreLabelRBI(text,idtd){
		var t1 = document.getElementById("RBI"+idtd.id);
		
		if ( t1 ){
			id = "#RBI"+idtd.id;
			$(id).html(text);
		}else{
				
			var label = $('<label>').text(text);
			label.attr('class','scoreRBI');
			label.attr('id','RBI'+idtd.id);
			label.attr('style','background-color: transparent;color: #ffff00;font-size: 6px !important; overflow: hidden ');
			var div = $('<div>').append(label);
			
			//Check ball
			var ball = document.getElementById("ball1_"+idtd.id);
			if ( ball )
				div.attr('style','width: 20px; position: absolute; right:0px;top:0px; z-index:400;overflow: hidden  ');
			else
				div.attr('style','width: 20px; position: absolute; right:0px;top:0px; z-index:400;overflow: hidden  ');
				
			$(idtd).append(div)
			
			
		}
		
	}
	
	
	function insertImage(text,idtd,line){
		var img = $('<img>');
		img.attr('style','overflow: hidden;display: block; float: left;position: absolute;right: 0px; top: 0px;z-index:500 ');
		img.attr('src',"images/"+line);
		img.attr('id','linetray'+idtd.id);
		
		var div = $('<div>').append(img);
		
		div.attr('style','right: 0px; top: 1px;position: absolute; z-index:500 ');
		
		$(idtd).append(div)
		//id = "#t1_"+idtd.id;
		//alert($('#t1').prop('id'));
		//$(id).attr('style','color: #ffff00;position: relative; right:-40;top:-70px;font-size: 6px !important; z-index:100;');
	}
	
</script>

<?

//Load team information
if ($_GET['team']=='visit'){
		$idteam=Yii::app()->user->getState('idteamvisiting');
		//echo "<script>alert('$idteam')</script>";
		if (!Yii::app()->user->getState('teamvisiting')){
			$criteria = new CDbCriteria();
			$criteria->addcondition("idteam=$idteam");
			$Team = Teams::model()->findAll($criteria);
			Yii::app()->user->setState('teamhome',$teamname=$Team[0]->Name);
		}else $teamname = Yii::app()->user->getState('teamvisiting');
		
}else{
		$idteam=Yii::app()->user->getState('idteamhome');
		//echo "<script>alert('$idteam')</script>";
		if (!Yii::app()->user->getState('teamhome')){
			$criteria = new CDbCriteria();
			$criteria->addcondition("idteam=$idteam");
			$Team = Teams::model()->findAll($criteria);
			Yii::app()->user->setState('teamhome',$teamname=$Team[0]->Name);
		}else $teamname = Yii::app()->user->getState('teamhome');
}


echo Yii::trace(CVarDumper::dumpAsString(Yii::app()->user->getState('idteamvisiting')),'turntobat');

function printeventback($eventype,$idtd){
	
	switch ($eventype){
		
		case '1': //HR
			echo "<script> $($idtd).css( 'background-image','url(images/Fieldhome.png)');</script>";
			//echo "<img src='images/Field1b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;
		
		case '2': //3B
			//echo "<script> alert($eventype); </script>";
			echo "<script> $($idtd).css('background-image','url(images/Field3b.png)') ;  </script>";
			//echo "<script> alert( $($idtd).offset().left ) </script>";
			//echo "<img src='images/Field3b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;
		
		case '3': //2B
			echo "<script> $($idtd).css( 'background-image','url(images/Field2b.png)');</script>";
			//echo "<img src='images/Field1b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;
		
		case '4': //1B
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			//echo "<img src='images/Field1b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;
	
		case '5': //BB
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			//echo "<img src='images/Field1b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;

		case '6': //HP
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			//echo "<img src='images/Field1b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;
		
		case '7': //KSO
			//echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			
		break;
		
		case '8': //KS
			//echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			
		break;
		
		case '9': //1B
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			//echo "<img src='images/Field1b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;
		
		case '11': //KSE
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '13': //KPB
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '14': //KWP
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '20': //KFCAR
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '21': //KFCAR
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '22': //KR1po
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '23': //KR2po
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '24': //KR3po
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
		break;
		
		case '37': //Out
			echo "<script> $($idtd).css( 'background-image','url(images/Field1.png)');</script>";
		break;
		
		case '38': //Ball trayectory
			//echo "<script> $($idtd).css( 'background-image','url(images/line1.png)');</script>";
		break;
		
		case '40': //Run to base 2
			echo "<script> $($idtd).css( 'background-image','url(images/Field2b.png)');</script>";
		break;
		
		case '41': //Run to base 3
			echo "<script> $($idtd).css( 'background-image','url(images/Field3b.png)');</script>";
		break;
		
		case '42': //Run to base 2
			echo "<script> $($idtd).css( 'background-image','url(images/Fieldhome.png)');</script>";
		break;
		
		
		
	}
	
	
}



function printeventtext($eventype,$idtd,$event){
		
	if ($event->text)
		echo "<script> scoreLabelT1('$event->text',$idtd)  </script>";
	
	if ($event->RBI)
		echo "<script> scoreLabelRBI('$event->RBI',$idtd)  </script>"; 
	
	switch ($eventype){
		
			
		
		case '2': //3B
			//echo "<script> scoreLabelT1('3B',$idtd)  </script>";		
		break;
		
		case '3': //2B
			//echo "<script> scoreLabelT1('2B',$idtd)  </script>";
			
		break;
		
		case '4': //1B
			//echo "<script> scoreLabelT1('1B',$idtd)  </script>";
		break;
		
		case '5': //BB
			//echo "<script> scoreLabelRBI('$event->RBI',$idtd)  </script>";
			
		break;
		
		case '6': //HP
			echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			//echo "<img src='images/Field1b.png' style='position: absolute;right: 0; bottom: 0; '>";
		break;
		
		case '7': //KSO
			//echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			
		break;
		
		case '8': //KS
			//echo "<script> $($idtd).css( 'background-image','url(images/Field1b.png)');</script>";
			
		break;
		
		
		case '31': //ball1 
			echo "<script> scoreLabelBall1($event->Misce,$idtd)  </script>";
			
		break;
		
		case '32': //ball2
			echo "<script> scoreLabelBall2($event->Misce,$idtd)  </script>";
		break;
		
		case '33': //ball3
			echo "<script> scoreLabelBall3($event->Misce,$idtd)  </script>";
		break;
		
		case '34': //ball4
			echo "<script> scoreLabelBall4($event->Misce,$idtd)  </script>";
		break;
		
		case '35': //ball5
			echo "<script> scoreLabelBall5($event->Misce,$idtd)  </script>";
		break;
		
		case '37': //Out
			echo "<script> scoreLabelOut($event->Misce,$idtd)  </script>";
		break;
		
		case '38': //Ball trayectory
			//echo "<script>alert('ball tray');</script>";	
			//echo "<script> $($idtd).css( 'background-image','url(images/line1.png)');</script>";
			$x = strstr($event->Misce, '-',true);
			if ($x < 200){
				$line = "'line1.png'";
				
			}else $line = "'line4.png'";
		 	echo "<script> insertImage($line,$idtd,$line); </script>";
		break;
		

	}
	
	

}

function checkAvancePlayer($player, $idLineup, $batterNumber,$inning){
		
	
$criteria = new CDbCriteria();
$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat>=$o AND Batter=$batterNumber AND Inning=$inning ");
$eventsArray = Events::model()->findAll($criteria);
$count_eventsArray = count ($eventsArray);


for ($i=0; $i < $count_eventsArray; $i++){
	
		switch ( $eventsArray[$i]->Events_type_idevents_type  ){
			case 1:
				return 'plate';
			break;
			case 2:
				$lastbase='3b';
			break;
			case 3:
				$lastbase='2b';
			break;
			case 4:
				$lastbase='1b';
			break;
			case 40:
				$lastbase='2b';
			break;
			case 41:
				$lastbase='3b';
			break;
			case 42:
				return 'plate';
			break;
			case 37:
				return $lastbase;
			break;
		} 
	
	
 }
}
function loadTableTeam ($id,$form,$numberTurntoBat,$idLineup){
				
	$positions = array('P', 'C', '1B', '2B', '3B','SS',
	  'LF', 'CF', 'RF', 'EF','DH', 'PH',
	  'PR',  'CR', 'EH',  'X');
	

	
	echo Yii::trace(CVarDumper::dumpAsString( Yii::app()->user->getState('idlineupvisiting') ),'teamvis');
	
	//LOAD LINEUP
	if ($idLineup){
		$criteria = new CDbCriteria();
		$criteria->addcondition("idlineup=$idLineup");
		$lineup = Lineup::model()->findAll($criteria);
	}else $idLineup=0;
	
	//LOAD TEAM INFO
	//if (! $teamid=$lineup[0]->Teams_idteam) $teamid = 0 ;
	
	
	
	//LOAD BATTERS
	$criteria = new CDbCriteria();
	$criteria->addcondition("Lineup_idlineup=$idLineup");
	$Batters = Batters::model()->findAll($criteria);
	
	$count = sizeof($Batters);
	$inning = 1;
	$e=1;
	for ($i=0;$i < $count; $i++){ //Batters cicle
		
		$sustitutionsCount=0;
		//Count sustitutions
		$s = $i;
		do{
			//$player_inning=$player=Players::model()->findByPk($Batters[$s]->Players_idplayer);  
			$sustitutionsCount=$s-$i;
			$s++;
		}while($Batters[$s]->Inning!=1 && $s < $count);
		
		$sustitutionsCount++;
		echo "<tr>";
		echo "<td rowspan='$sustitutionsCount' class='scoreboardplayer'>$e</td>";
		
		//echo "<td>";		
		//echo "<table style='margin:0px !important;height:100%'>";
		
		//Loop three players
		//for ($a=0; $a < 3; $a++){
	
		//Load player data
		$player=Players::model()->findByPk($Batters[$i]->Players_idplayer); 
		
			if ($player->Firstname) {
			//echo "<tr>";
			echo "<td class='scoreboardplayer' width:150px>".$player->Firstname." ".$player->Lastname[0]."</td>";
			echo "<td class='scoreboardplayer'>".$positions[$Batters[$i]->DefensePosition-1]."</td>";
			echo "<td class='scoreboardplayer'>".$Batters[$i]->Inning."</td>";
			//echo "</tr>";	
			}
			
			//$batterNumber = $batterNumber=$Batters[$i]->BatterPosition;
			
			$batterNumber=$Batters[$i]->BatterPosition;
			
			
			//echo "<script> alert($numberTurntoBat) </script>";
			//Inning fields graphics
			for ($o=1;$o <= $numberTurntoBat; $o++){ //Inning cicle
			$criteria = new CDbCriteria();
			$idgame = Yii::app()->user->getState('idgame');
			
				// if there are sustitutions
				for ($k=1; $k < $sustitutionsCount; $k++) {
					
					//Check the next batter's inning
					if ($Batters[$K+1]->Inning == $o){
						$tmp=$Batters[$K+1]->BatterPosition;
						
						$batterNumber=$Batters[$K+1]->BatterPosition; 
					}
				}
			$idtd='td'.$o.$i;
			
			echo Yii::trace(CVarDumper::dumpAsString($batterNumber),'batterPosition');
			
			echo "<td rowspan='$sustitutionsCount'class='scoreboardtd' style='background-image: url(images/Plays.jpg)'>";
			
			echo "<div id=$idtd style='height:67px;max-height:67px;position:relative'>";																																																																					
			//Load events on Inning 
			// in order to check the position of the player in the inning
			
			$criteria->order = 'Events_type_idevents_type';
			
			
			//Check for HR or run or runplate   (HR or run or runplate events type)
			//$criteria->addcondition("t.Lineup_idlineup=$idLineup AND t.turntobat=$o AND Batter=$batterNumber AND ( t.Events_type_idevents_type='1' OR Events_type_idevents_type='42')");
			$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat>=$o AND Batter=$batterNumber AND (Events_type_idevents_type = 2 OR  (Events_type_idevents_type = 42))");
			//$criteria->join='INNER JOIN Batters ON Batters.Lineup_idlineup=t.Lineup_idlineup';
			$events = new Events;
			$eventsArray = Events::model()->findAll($criteria);
			$count_eventsArray = count ($eventsArray);
			
			echo Yii::trace(CVarDumper::dumpAsString($count_eventsArray),'check1');
			
			if (! $count_eventsArray) { //Player run base 3 or Base 2 since hitting
				$criteria = new CDbCriteria();
				$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat>=$o AND Batter=$batterNumber AND (Events_type_idevents_type = 2 OR  (Events_type_idevents_type = 41))");
				$eventsArray = Events::model()->findAll($criteria);
				$count_eventsArray = count ($eventsArray);
				echo Yii::trace(CVarDumper::dumpAsString($count_eventsArray),'check2');
			}
			
			
			
			if (! $count_eventsArray) { //Player base 2 
				$criteria = new CDbCriteria();
				$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat=$o AND Batter=$batterNumber AND ( Events_type_idevents_type = 40 OR Events_type_idevents_type = 3) ");
				$eventsArray = Events::model()->findAll($criteria);
				$count_eventsArray = count ($eventsArray);
				echo Yii::trace(CVarDumper::dumpAsString($count_eventsArray),'check3');
			}
			
			
			
			if (! $count_eventsArray) { //Player base 1, run base 1, bb, hp, kse=11 Kpb=13 kwp=14 	KFCAR=20 KFCNB=21 KR1po=22 KR2po=23 KR3po=24 2sac=27 1sac=28 
				$criteria = new CDbCriteria();
				$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat=$o AND Batter=$batterNumber AND  ( Events_type_idevents_type <= 6 OR Events_type_idevents_type IN (11, 13, 14, 20,21,22,23,24,27,28,29,30) )"); //
				$eventsArray = Events::model()->findAll($criteria);
				$count_eventsArray = count ($eventsArray);
				echo Yii::trace(CVarDumper::dumpAsString($criteria),'check4');
			}
			
			if (! $count_eventsArray) { // Print field empty, Out
				$criteria = new CDbCriteria();
				$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat=$o AND Batter=$batterNumber AND  ( Events_type_idevents_type IN (37) )"); 
				$eventsArray = Events::model()->findAll($criteria);
				$count_eventsArray = count ($eventsArray);
				echo Yii::trace(CVarDumper::dumpAsString($criteria),'check4');
			}
			
			//Print Bases
			for ($k=0; $k < $count_eventsArray; $k++) {
				
				printeventback($eventsArray[$k]->Events_type_idevents_type,$idtd);
					
			}
			
			//printeventback(-1,$idtd);
			
			$criteria = new CDbCriteria();
			$criteria->addcondition("Lineup_idlineup=$idLineup AND turntobat=$o AND Batter=$batterNumber  "); //
			$eventsArray = Events::model()->findAll($criteria);
			$count_eventsArray = count ($eventsArray);
			
			
			//Print Event's texts
			for ($k=0; $k < $count_eventsArray; $k++) {
				
				printeventtext($eventsArray[$k]->Events_type_idevents_type,$idtd,$eventsArray[$k]);
					
			}
			
			$count_eventsArray=0;
				echo "<div  style='height:67px;max-height:67px;z-index:600;position:absolute;top:25px;right:0px'>";
				$idevent=$eventsArray[0]->idevents;
				if ($eventsArray[0]->Inning) $inning = $eventsArray[0]->Inning;
				
				//if(! $idevent) $idevent = -1;
				if ( $idevent)
					echo CHtml::button('',array('onclick'=>'gotoAtBat('.$idevent.')','class'=>'scoreboardtdButton'));
				else  echo CHtml::button('',array('onclick'=>"gotoAtBatNewPlay($o, $inning, $e)",'class'=>'scoreboardtdButton'));
				echo "</div>"; 
			echo "</div>"; 
			echo " </td>";
			}
			
		echo "</tr>";
		if ($e==9) $e=0;
		else $e++;
		
		
		//Fill sustitutions player spaces
		if ($sustitutionsCount >1)
		for ($j=$i;$j<$sustitutionsCount;$j++){
		echo "<tr>";
			$j++; //Next player
			$i++; 
			$player=Players::model()->findByPk($Batters[$j]->Players_idplayer); 
			if ($player->Firstname) {
			//echo "<tr>";
			echo "<td class='scoreboardplayer' width:150px>".$player->Firstname." ".$player->Lastname[0]."</td>";
			echo "<td class='scoreboardplayer'>".$positions[$Batters[$j]->DefensePosition-1]."</td>";
			echo "<td class='scoreboardplayer'>".$Batters[$j]->Inning."</td>";
			//echo "</tr>";	
			}
		echo "</tr>";
		}
		
		
		
		
	}
	
	$e=$count+1;
	//Fill empty spaces on scoreboard
	for ($i=$count;$i < 11; $i++){
		echo "<tr>";
		echo "<td rowspan=1 class='scoreboardplayer'>$e</td>";
		echo "<td rowspan=1 class='scoreboardplayer'></td>";
		echo "<td rowspan=1 class='scoreboardplayer'></td>";
		echo "<td rowspan=1 class='scoreboardplayer'></td>";
			
		for ($u=0;$u < $numberTurntoBat; $u++){
			
		echo "<td class='scoreboardtd' style='background-image: url(images/Plays.jpg)'> </td>";
		}
		echo "</tr>";
		
		if ($e==9) $e=0;
		else $e++;
	}
	
	
	
}
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
)); ?>

<?

//Set lineup var
if (Yii::app()->user->getState('idteamhome') == $idteam) {
	$name = Yii::app()->user->getState('teamhome');
	
	$idLineup=Yii::app()->user->getState('idlineuphome');
}else {
	$name = Yii::app()->user->getState('teamvisiting');
	
	$idLineup=Yii::app()->user->getState('idlineupvisiting');
}



if ($idLineup){
	//Get the numbers of turn to bat
	$criteria = new CDbCriteria();
	$eventsmax = Events::model()->findBySql("select MAX(turntobat) as maxatbat FROM Events WHERE Lineup_idlineup=$idLineup");
	$numberTurntoBat = $eventsmax['maxatbat'];
}



if (!$numberTurntoBat || $numberTurntoBat < 9) $numberTurntoBat = 9;
			

$tablesize = 220+67*$numberTurntoBat;

$teamname = $_GET['team']=='visit' ? 'ScoreBook – Visitors – ' . $teamname : 'ScoreBook – Home – ' . $teamname;

?>

<script>
	$("#span-23").css('display','none');
</script>

<h1><?php echo $teamname; ?></h1>

<div style="height:800px;width:850px;overflow:auto;">
	
<table id='tablescore' style='width:<?echo $tablesize;?>px'>
	
	<thead>
		<th class='redbar'> </th> <th width='150px' class='redbar'> PLAYER </th> <th class='redbar'>P</th> <th class='redbar'>I</th> 
		
		<?
		
		for ($i=1;$i <= $numberTurntoBat; $i++){
			echo "<th class='redbar'>$i</th>";	
		}
		
		?>
	
	</thead>
	
	<?php 
		loadTableTeam ($idteam,$form,$numberTurntoBat,$idLineup); 
	?>
	
</table>

</div>
<?
echo CHtml::hiddenField('link','',array('id'=>'link'));
echo CHtml::hiddenField('idevent','',array('id'=>'idevent'));
echo CHtml::hiddenField('inning','',array('id'=>'inning'));
echo CHtml::hiddenField('batter','',array('id'=>'batter'));
echo CHtml::hiddenField('turntobat','',array('id'=>'turntobat'));
?>

<?php $this->endWidget(); ?>
