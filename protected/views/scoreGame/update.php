<?php
/* @var $this GamesController */
/* @var $model Games */
$header = Yii::app()->request->getParam('id') ? "Score Game - ".$model->teamsIdteamHome['Name']. " VS " . $model->teamsIdteamVisiting['Name'] : "Add New Game";
?>

<h1><?php echo $header; ?></h1>

<div id="redbar"></div>
<script>
    $("#redbar").append($("#span-23"));
</script>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>