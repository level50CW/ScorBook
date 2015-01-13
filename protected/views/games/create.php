<?php
/* @var $this GamesController */
/* @var $model Games */
?>


<?php 
	$lineup = new Lineup;
	
	$formLineup=$this->beginWidget('CActiveForm', array(
    'id'=>'lineup-form',
    'enableAjaxValidation'=>true,
    'focus'=>array($lineup,'Name'),
    'action'=>'/index.php?r=lineup/create'
)); ?>





<?php $this->endWidget(); ?>


<h1>GAME INFO</h1>

<div id="redbar"></div>
<script>
	$("#redbar").append($("#span-23"));
</script>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>