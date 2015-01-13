<?php
/* @var $this StatsfieldingController */
/* @var $model Statsfielding */

$this->breadcrumbs=array(
	'Statsfieldings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Statsfielding', 'url'=>array('index')),
	array('label'=>'Create Statsfielding', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#statsfielding-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Statsfieldings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'statsfielding-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Idstatsfield',
		'Players_idplayer',
		'Games_idgames',
		'G',
		'GS',
		'INN',
		/*
		'TC',
		'PO',
		'A',
		'E',
		'DP',
		'SB',
		'CS',
		'SBPCT',
		'PB',
		'C_WP',
		'FPCT',
		'RF',
		*/
		array(
			'class'=>'CButtonColumn',
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
