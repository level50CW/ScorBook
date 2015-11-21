<?php
/* @var $this GamesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Games',
);

$this->menu=array(
	array('label'=>'Create Games', 'url'=>array('create')),
	array('label'=>'Manage Games', 'url'=>array('admin')),
);
?>

<h1>Games</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
