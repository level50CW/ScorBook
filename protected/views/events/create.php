
<script> Events_type_idevents_type =  idevents = 0 </script>

<?php
/* @var $this EventsController */
/* @var $model Events */

include 'eventsFunctions.php';


resetBases();


$defensiveteam = setBattingTeamName($model);


//Load events when id event is provided
$idevent = isset($_GET['idevent']) ? $_GET['idevent'] : null;
if ($idevent) {
    $event = Events::getById($idevent);
    
    //Event doesn't exists
    if (!$event)
        $this->redirect('index.php?r=events/create&team=home');
    
    $model = $event[0];
        
    $lin                    = $event[0]->Lineup_idlineup;
    $model->Lineup_idlineup = $event[0]->Lineup_idlineup;
    $model->Inning          = $event[0]->Inning;
    
    //Load lineup by eventid
    $lineup = Lineup::getById($model->Lineup_idlineup);
    
    Yii::app()->user->setState('battingteam', $lineup[0]->Teams_idteam);
    Yii::app()->user->setState('batterNumber', $event[0]->Batter);
    Yii::app()->user->setState('turntobat', $event[0]->turntobat);
    
    Yii::app()->user->setState('hitterBase1', $event[0]->b1);
    Yii::app()->user->setState('hitterBase2', $event[0]->b2);
    Yii::app()->user->setState('hitterBase3', $event[0]->b3);
    
    $model->idevents = $idevent;
    
} else {
    
    if (Yii::app()->user->getState('idlineuphome') && Yii::app()->user->getState('idlineupvisiting') && empty($_GET['idevent'])) {
        
        
        // Get the last Inning  	
        $eventsmax        = Events::model()->findBySql("select MAX(inning) as maxinning FROM Events WHERE Lineup_idlineup=" . Yii::app()->user->getState('idlineuphome'));
        $numberInningHome = $eventsmax['maxinning'];
		
        // Get the last Inning  													
        $eventsmax            = Events::model()->findBySql("select MAX(inning) as maxinning FROM Events WHERE Lineup_idlineup=" . Yii::app()->user->getState('idlineupvisiting'));
        $numberInningVisiting = $eventsmax['maxinning'];
		
        ///AND  1 != $numberInningVisiting ???
        if ($numberInningHome == $numberInningVisiting AND $numberInningVisiting) { //If both have same number of Innings, batting team is home;
            $model->Lineup_idlineup = Yii::app()->user->getState('idlineuphome');
            $inning                 = $model->Inning = $numberInningHome;
        } else {
            $model->Lineup_idlineup = Yii::app()->user->getState('idlineupvisiting');
            $inning                 = $model->Inning = $numberInningVisiting;
        }
        
        if (!$model->Inning)
            $model->Inning = 1;
        
        
        $eventsmax       = Events::model()->findBySql("select MAX(turntobat) as maxturntobat FROM Events WHERE Lineup_idlineup=" . $model->Lineup_idlineup . " AND Inning=" . $model->Inning);
        $numberTurntoBat = $eventsmax['maxturntobat'];
        
        
        //if (!Yii::app()->user->getState('turntobat'))  **** Removido causa Turntobat undefinido al existir  Yii::app()->user->getState('turntobat')
        if ($numberTurntoBat) {
            Yii::app()->user->setState('turntobat', $numberTurntoBat);
        } else {
            $numberTurntoBat = 1;
            Yii::app()->user->setState('turntobat', 1);
        }
        
        $eventsmax  = Events::model()->findBySql("select COUNT(Events_type_idevents_type) as numberOuts FROM Events WHERE Events_type_idevents_type=37 AND Lineup_idlineup=" . $model->Lineup_idlineup . " AND Inning=$model->Inning ORDER BY idevents");
        $numberOuts = $eventsmax['numberOuts'];
        
        if ($numberOuts >= 3) { // There is not events but next inning comming out
            
            if ($model->Lineup_idlineup == Yii::app()->user->getState('idlineuphome')) { //Home Lineup with 3 out 
                $model->Lineup_idlineup = Yii::app()->user->getState('idlineupvisiting');
                Yii::app()->user->setState('battingteam', Yii::app()->user->getState('idteamvisiting'));
                $model->Inning = $model->Inning + 1;
                Yii::app()->user->setState('turntobat', $numberTurntoBat + 1);
                resetBases();
                
            } else { //Visiting line up with 3 outs
                $model->Lineup_idlineup = Yii::app()->user->getState('idlineuphome');
                Yii::app()->user->setState('battingteam', Yii::app()->user->getState('idteamhome'));
                $model->Inning = $model->Inning;
                resetBases();
                
            }
            
            setBattingTeamName($model);
            Yii::app()->user->setState('outs', 0);
        } else
            Yii::app()->user->setState('outs', $numberOuts);
        
        if (!$model->Inning)
            $model->Inning = 1;
        
        Yii::app()->user->setState('inning', $model->Inning);
		
        //Set play number checking the last play in the events 
        $playmax = Events::model()->findBySql("select MAX(play) as maxplay FROM Events WHERE Lineup_idlineup=" . Yii::app()->user->getState('idlineuphome') . " OR Lineup_idlineup=" . Yii::app()->user->getState('idlineupvisiting') . "");
        $count   = sizeof($playmax);
        $playN   = $playmax['maxplay'];
        
        if ($count) {
            $model->play = $playmax['maxplay'] + 1;
            
        } else
            $model->play = 1;
        
        
        //Load the play number
        if (isset($event) && $event->play) {
            $model->play = $event->play + 1;
        }
        
        
        //Check for last batter event type 77
        //Get the max number of play BY IDLINEUP of the batting team
        $playmax = Events::model()->findBySql("select MAX(play) as maxplay FROM Events WHERE Lineup_idlineup=$model->Lineup_idlineup");
        $playN   = $playmax['maxplay'];
        
        if ($playN) {
            $lstBatter = Events::model()->findBySql("select * FROM Events WHERE Lineup_idlineup=$model->Lineup_idlineup AND play = $playN AND Events_type_idevents_type='77'");
        }
        $count = empty($lstBatter) ? 0 : sizeof($lstBatter);
        
        if ($count) {
            
            if ($model->Lineup_idlineup == Yii::app()->user->getState('idlineuphome')) { //Home Lineup with 3 out 
                $model->Lineup_idlineup = Yii::app()->user->getState('idlineupvisiting');
                Yii::app()->user->setState('battingteam', Yii::app()->user->getState('idteamvisiting'));
                $model->Inning = $model->Inning + 1;
                Yii::app()->user->setState('turntobat', $numberTurntoBat + 1);
                resetBases();
                
                
            } else { //Visiting line up with 3 outs
                $model->Lineup_idlineup = Yii::app()->user->getState('idlineuphome');
                Yii::app()->user->setState('battingteam', Yii::app()->user->getState('idteamhome'));
                $model->Inning = $model->Inning;
                resetBases();
                
            }
            //Batter should be the next in the new inning
            //Yii::app()->user->setState('batterNumber',1); // Set turn to bat to first batter
            setBattingTeamName($model);
            Yii::app()->user->setState('outs', 0);
            
        }
		
        echo Yii::trace(CVarDumper::dumpAsString((empty($_GET['inning']) ? '' : $_GET['inning']) . "-" . (empty($_GET['turntobat']) ? '' : $_GET['turntobat']) . "-" . (empty($_GET['batter']) ? '' : $_GET['batter'])), 'entreprueba');
        
        if (!empty($_GET['inning']) && !empty($_GET['turntobat']) && !empty($_GET['batter'])) {
            $model->Inning = $_GET['inning'];
            Yii::app()->user->setState('inning', $model->Inning);
            
            $model->turntobat = $_GET['turntobat'];
            Yii::app()->user->setState('turntobat', $model->turntobat);
            
            $model->Batter = $_GET['batter'];
            Yii::app()->user->setState('batterNumber', $model->Batter);
            
        }
		
        //Check if there are players on bases
        checkLastBases($model);
        
    }
    
    //Get the number of Batters
    $criteria = new CDbCriteria();
    $criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup");
    $Batters = Batters::model()->findAll($criteria);
    $count   = sizeof($Batters);
    
    // Get the last Batter of the inning 
    if (empty($numberLastBatter)) {
        $criteria = new CDbCriteria();
        $criteria->addcondition("Lineup_idlineup=" . $model->Lineup_idlineup . " AND inning=$model->Inning AND turntobat=$numberTurntoBat");
        $eventsmax        = Events::model()->findAll($criteria);
        //$eventsmax = Events::model()->findBySql("select * FROM Events WHERE Lineup_idlineup=".$model->Lineup_idlineup ." AND inning=$model->Inning AND turntobat=$numberTurntoBat");
        $numb             = (count($eventsmax) > 0) ? (count($eventsmax) - 1) : 0;
        $numberLastBatter = empty($eventsmax[$numb]) ? 0 : $eventsmax[$numb]->Batter;
        //echo "Lasb".$numberLastBatter."<br>";
    }
    
    // Get the last Batter of the past inning
    if (empty($numberLastBatter)) {
        $befInning = $model->Inning - 1;
        $criteria  = new CDbCriteria();
        $criteria->addcondition("Lineup_idlineup=" . $model->Lineup_idlineup . " AND inning=$befInning");
        $eventsmax        = Events::model()->findAll($criteria);
        //$eventsmax = Events::model()->findBySql("select MAX(Batter) as maxbatter FROM Events WHERE Lineup_idlineup=".$model->Lineup_idlineup ." AND inning=$befInning");
        //$numberLastBatter = $eventsmax['maxbatter'];
        $numb             = (count($eventsmax) > 0) ? (count($eventsmax) - 1) : 0;
        $numberLastBatter = empty($eventsmax[$numb]) ? 0 : $eventsmax[$numb]->Batter;
    }
    
    if ($numberLastBatter > $count) //Last batter 
        Yii::app()->user->setState('batterNumber', 1);
    else {
        Yii::app()->user->setState('batterNumber', $numberLastBatter + 1);
    }
}
?>

<h1> <?
setBattingTeamName($model);
echo (Yii::app()->user->getState('battingteam') == Yii::app()->user->getState('idteamvisiting')) ? 'TOP ' : 'BOTTOM';
?> OF THE <?php
echo $model->Inning;
?>
	<?
switch ($model->Inning) {
    case 1:
        echo 'ST';
        break;
    case 2:
        echo 'ND';
        break;
    case 3:
        echo 'RD';
        break;
    default:
        echo 'TH';
        break;
}


?>
	
	 / <?
echo Yii::app()->user->getState('$battingteamName');
?></h1>
<div id="redbar"></div>
<script>
	$("#redbar").append($("#span-23"));
</script>
<?php
echo $this->renderPartial('_form', array(
    'model' => $model
));
?>
