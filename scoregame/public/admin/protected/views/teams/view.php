<?php
/* @var $this TeamsController */
/* @var $model Teams */

?>

<h1>View Team - <?php echo $model->Name; ?></h1>


<?php echo $this->renderPartial('_form', array('model'=>$model,'disabled'=>true)); ?>