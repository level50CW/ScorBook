<?php
/* @var $this GamesController */
/* @var $model Games */
$header = Yii::app()->request->getParam('id') ? "Game - ".$model->teamsIdteamHome['Name']. " VS " . $model->teamsIdteamVisiting['Name'] : "Add New Game";
?>

<h1><?php echo $header; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
                                               'disabled'=>true)); ?>