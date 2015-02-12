<?php
/* @var $this EventsController */
/* @var $model Events */

$idlineuphome = Yii::app()->user->getState('idlineuphome');
$idlineupvisiting = Yii::app()->user->getState('idlineupvisiting');
$idteamvisiting = Yii::app()->user->getState('idteamvisiting');
$teamvisiting = Yii::app()->user->getState('teamvisiting');

Yii::app()->user->setState('battingteam',$idteamvisiting);
$model->Lineup_idlineup = $idlineupvisiting;
$model->Inning = 1;

$eventsmax        = Events::getByLineupInning($model->Lineup_idlineup, $model->Inning);
$numb             = (count($eventsmax) > 0) ? (count($eventsmax) - 1) : 0;
$numberLastBatter = empty($eventsmax[$numb]) ? 0 : $eventsmax[$numb]->Batter;
Yii::app()->user->setState('batterNumber', $numberLastBatter + 1);
?>

<h1> <?
echo ($idteamvisiting == $idteamvisiting) ? 'TOP ' : 'BOTTOM';
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
echo strtoupper($teamvisiting);
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
