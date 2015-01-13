<?php
//edit or add new one
$header = Yii::app()->request->getParam('id') ? "Schedule - ".$model->teamsIdteamHome['Name']. " VS " . $model->teamsIdteamVisiting['Name'] .( $model->date ? ' - ' . date('F j',strtotime($model->date)) : '') : "Schedule – Add New Game";
?>

<h1><?php echo $header; ?></h1>

<div id="redbar"></div>
<script>
    $("#redbar").append($("#span-23"));
</script>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>