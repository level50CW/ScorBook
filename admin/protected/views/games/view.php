<?php
/* @var $this GamesController */
/* @var $model Games */

$this->breadcrumbs=array(
    'Games'=>array('index'),
    '"' . $model->teamsIdteamHome['Name']. '" With "' . $model->teamsIdteamVisiting['Name'] . '"',
);

?>

<h1>Game <?php echo $model->teamsIdteamHome['Name']. " " . $model->teamsIdteamVisiting['Name']; ?></h1>
<?php echo $this->renderPartial('_FormSchedule', array('model'=>$model,
                                               'disabled'=>true)); ?>