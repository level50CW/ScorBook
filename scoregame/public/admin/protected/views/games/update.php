<?php
/* @var $this GamesController */
/* @var $model Games */
?>

<h1>Game <?php echo $model->teamsIdteamHome['Name']. " " . $model->teamsIdteamVisiting['Name']; ?></h1>

<div id="redbar"></div>
<script>
	$("#redbar").append($("#span-23"));
</script>

<?php echo $this->renderPartial('_FormScoreGame', array('model'=>$model)); ?>