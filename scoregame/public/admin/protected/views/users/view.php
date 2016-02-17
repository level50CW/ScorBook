<?php
/* @var $this UsersController */
/* @var $model Users */
?>

<h1>View User - <?php echo ($model->Lastname ? $model->Lastname. ", " : "" ) .$model->Firstname ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'disabled'=>true)); ?>