<?php
/* @var $this LineupController */
/* @var $model Lineup */


/* $this->menu=array(
	array('label'=>'List Lineup', 'url'=>array('index')),
	array('label'=>'Manage Lineup', 'url'=>array('admin')),
); */
?>

<?

if ($_GET['team']) {

    $homeTeamID = Yii::app()->user->getState('idteamhome');
    $visitingTeamID = Yii::app()->user->getState('idteamvisiting');

    $model->Games_idgame = Yii::app()->user->getState('idgame');

    if ($_GET['team'] == 'home') {
        $model->Teams_idteam = Yii::app()->user->getState('idteamhome');
        $criteria = new CDbCriteria();
        $criteria->addcondition("idteam=$model->Teams_idteam");
        $Team = Teams::model()->findAll($criteria);
        @Yii::app()->user->setState('teamhome', $Team[0]->Name);
        echo @Yii::trace(CVarDumper::dumpAsString($Team[0]->Name), 'teamhom');

    } else {
        $model->Teams_idteam = Yii::app()->user->getState('idteamvisiting');
        $criteria = new CDbCriteria();
        $criteria->addcondition("idteam=$model->Teams_idteam");
        $Team = Teams::model()->findAll($criteria);
        @Yii::app()->user->setState('teamvisiting', $Team[0]->Name);
        echo Yii::trace(CVarDumper::dumpAsString(Yii::app()->user->getState('teamvisiting')), 'teamvis');
    }
} else {
    $model->Teams_idteam = Yii::app()->user->getState('idteamhome');
}

//Yii::app()->user->setState('iddivisionhome', $_POST['Games']['Division_iddivision_home']);
//Yii::app()->user->setState('iddivisionvisiting', $_POST['Games']['Division_iddivision_visiting']);

$team = Teams::model()->findByPk($model->Teams_idteam);
$header = $_GET['team'] == 'home' ?
"Home Team Line Up – ".$team->Name:
"Visiting Team Line Up – ".$team->Name;
?>


<h1><? echo $header;?></h1>

<div id="redbar"></div>
<script>
    $("#span-23").css('display', 'none');
</script>

<?php echo $this->renderPartial('_form', array('model' => $model,
                                               'homeTeamID' => $homeTeamID,
                                               'visitingTeamID'=>$visitingTeamID)); ?>


