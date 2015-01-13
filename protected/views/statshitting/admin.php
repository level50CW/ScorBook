<?php
/* @var $this StatshittingController */
/* @var $model Statshitting */

$this->breadcrumbs=array(
	'Statshittings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Statshitting', 'url'=>array('index')),
	array('label'=>'Create Statshitting', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#statshitting-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Statshittings</h1>

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
	'id'=>'statshitting-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'idstatshit',
		'Players_idplayer',
		'Games_idgame',
		'G',
		'AB',
		'R',
		/*
		'H',
		'v2B',
		'v3B',
		'HR',
		'RBI',
		'BB',
		'SO',
		'SB',
		'CS',
		'AVG',
		'OBP',
		'SLG',
		'OPS',
		'IBB',
		'HBP',
		'SAC',
		'SF',
		'TB',
		'XBH',
		'GDP',
		'GO',
		'AO',
		'GO_AO',
		'NP',
		'PA',
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
