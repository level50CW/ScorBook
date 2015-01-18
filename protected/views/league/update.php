<?php
/* @var $this LeagueController */
/* @var $model League */
?>

<h1>Update League <?php echo $model->Name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>