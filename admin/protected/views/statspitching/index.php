<?php
/* @var $this StatspitchingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Statspitchings',
);

$this->menu=array(
	array('label'=>'Create Statspitching', 'url'=>array('create')),
	array('label'=>'Manage Statspitching', 'url'=>array('admin')),
);
?>

<h1>Statspitchings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
