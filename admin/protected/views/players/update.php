<?php
/* @var $this PlayersController */
/* @var $model Players */
?>

<h1>Rosters - Update Player – <?php echo $model->Firstname." ".$model->Lastname?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>