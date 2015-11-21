<?php
/* @var $this PlayerTeamController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Player Teams',
);

$this->menu=array(
	array('label'=>'Create PlayerTeam', 'url'=>array('create')),
	array('label'=>'Manage PlayerTeam', 'url'=>array('admin')),
);
?>

<h1>Player Teams</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
