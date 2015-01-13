<?php
/* @var $this PlayersController */
/* @var $model Players */
?>

<h1>Rosters - View Player - <?php echo $model->Firstname." ".$model->Lastname; ?> </h1>

<?php echo $this->renderPartial('_form_view', array('model'=>$model)); ?>




<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idplayer',
		'Firstname',
		'Lastname',
		'Number',
		'Teams_idteam',
		'Position',
		'Bats',
		'Throws',
	),
));*/ ?>

	<br>
	
	<div align='center'> 
		
	<? /*if ($model->Photo) { ?>
	<?php $this->beginWidget('application.extensions.thumbnailer.Thumbnailer', array(
								        'thumbsDir' => 'images/thumbs',
								        'thumbWidth' => 125,
								        //'thumbHeight' => 150, // Optional
								    )
								); ?>
	<img src="images/players/<?php echo $model->thumb?>"/>
	<?php $this->endWidget(); ?>
	<?}*/
	?>
	</div>