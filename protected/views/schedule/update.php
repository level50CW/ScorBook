<?php
//edit or add new one

$header = Yii::app()->request->getParam('id') ? 
	'Schedule - <span id="header-teamNameHome">'.$model->teamsIdteamHome['Name']. '</span> VS <span id="header-teamNameVisiting">' . $model->teamsIdteamVisiting['Name'] .'</span>'.
		( $model->date ? ' - <span id="header-date">'.date_create_from_format('m-d-Y H:i', $model->date)->format('F j').'</span>' : ''):
	'Schedule – Add New Game';
?>

<h1><?php echo $header; ?></h1>

<div id="redbar"></div>
<script>
    $("#redbar").append($("#span-23"));
</script>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>