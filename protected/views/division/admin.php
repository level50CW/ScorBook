<?php
/* @var $this DivisionController */
/* @var $model Division */

/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#division-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<h1>Divisions - Manage Divisions</h1>




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'division-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		//'iddivision',
		'Name',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
	'pager'=>array(
        'class'=>'CLinkPager',
        'header'         => '',
        'firstPageLabel' => '&nbsp; First &nbsp;',
        'lastPageLabel'  => '&nbsp; Last &nbsp;',
        'prevPageLabel'  => '&lt; Previous',
        'nextPageLabel'  => 'Next &gt;',
    ),
)); ?>
