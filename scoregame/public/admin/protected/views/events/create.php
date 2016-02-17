<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $state 
		$visitingTeamTable
		$homeTeamTable
		$visitingRunsTable
		$homeRunsTable

*/ 

?>

<h1> <?
//echo ($state->idteamvisiting == $state->idteamvisiting) ? 'TOP ' : 'BOTTOM';
?>TOP OF THE <?php
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
echo strtoupper($state->teamvisiting);
?></h1>
<div id="redbar"></div>
<?php
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'state'=>$state,
	'visitingTeamTable'=>$visitingTeamTable,
	'homeTeamTable'=>$homeTeamTable,
	'visitingRunsTable'=>$visitingRunsTable,
	'homeRunsTable'=>$homeRunsTable
));
?>
