<?php
/* @var $this SeasonController */
/* @var $model Season */

?>

<h1>View Season <?php echo $model->season; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'disabled'=>true)); ?>
