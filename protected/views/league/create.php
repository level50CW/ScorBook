<?php
/* @var $this LeagueController */
/* @var $model League */

$this->breadcrumbs=array(
	'Leagues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List League', 'url'=>array('index')),
	array('label'=>'Manage League', 'url'=>array('admin')),
);
?>

<h1>Create League</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>