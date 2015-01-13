<?php
/* @var $this GameOfficialsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Game Officials',
);

$this->menu=array(
	array('label'=>'Create GameOfficials', 'url'=>array('create')),
	array('label'=>'Manage GameOfficials', 'url'=>array('admin')),
);
?>

<h1>Game Officials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
