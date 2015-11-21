<?php
/* @var $this GameOfficialsController */
/* @var $model GameOfficials */

$this->breadcrumbs=array(
	'Game Officials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GameOfficials', 'url'=>array('index')),
	array('label'=>'Manage GameOfficials', 'url'=>array('admin')),
);
?>

<h1>Create GameOfficials</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>