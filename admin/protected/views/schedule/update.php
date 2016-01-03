<?php
//edit or add new one
if (isset($model->date)){
	$date = date_create_from_format('m-d-Y H:i', $model->date);
	if ($date != false)
		$date = $date->format('F j');
}


$header = Yii::app()->request->getParam('id') ? 
	'Schedule - <span id="header-teamNameHome">'.$model->teamsIdteamHome['Name']. '</span> VS <span id="header-teamNameVisiting">' . $model->teamsIdteamVisiting['Name'] .'</span>'.
		( isset($date)? 
			' - <span id="header-date">'.$date.'</span>' :
			''):
	'Schedule – Add New Game';
?>

<h1><?php echo $header; ?></h1>

<div id="redbar"></div>
<script>
    $("#redbar").append($("#span-23"));
</script>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>