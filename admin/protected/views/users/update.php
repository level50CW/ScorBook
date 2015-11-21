<?php
/* @var $this UsersController */
/* @var $model Users */
?>

<h1>Update User - <?php echo ($model->Lastname ? $model->Lastname. ", " : "" ) .$model->Firstname ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>