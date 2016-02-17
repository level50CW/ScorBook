<?php
/* @var $this StatspitchingController */
/* @var $model Statspitching */

$this->breadcrumbs=array(
	'Statspitchings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Statspitching', 'url'=>array('index')),
	array('label'=>'Create Statspitching', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#statspitching-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Statspitchings</h1>

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
	'id'=>'statspitching-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'idstatspit',
		'Players_idplayer',
		'Games_idgame',
		'W',
		'L',
		'ERA',
		/*
		'G',
		'GS',
		'SV',
		'SVO',
		'IP',
		'H',
		'R',
		'ER',
		'HR',
		'BB',
		'SO',
		'AVG',
		'WHIP',
		'CG',
		'SHO',
		'HB',
		'IBB',
		'GF',
		'HLD',
		'GIDP',
		'GO',
		'AO',
		'WP',
		'BK',
		'SB',
		'CS',
		'PK',
		'TBF',
		'NP',
		'WPCT',
		'GO_AO',
		'OBP',
		'SLG',
		'OPS',
		'K_9',
		'BB_9',
		'K_BB',
		'P_IP',
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
