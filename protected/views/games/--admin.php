<?php
/* @var $this GamesController */
/* @var $model Games */



if ( Yii::app()->session['role']  == 'admins' ){ 

	$this->menu=array(
	array('label'=>'Teams', 'url'=>array('teams/admin')),
	array('label'=>'Players', 'url'=>array('players/admin')),
	array('label'=>'Users', 'url'=>array('users/admin')),
	array('label'=>'New Game', 'url'=>array('create')),
	);
	//array('label'=>'Officials', 'url'=>array('officials/admin')),
	
}else if ( Yii::app()->session['role']  == 'roster' ){
	
	$this->menu=array(
	array('label'=>'New Game', 'url'=>array('create')),
    array('label'=>'Players', 'url'=>array('players/admin')),
	);
	
}


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#games-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Games</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'games-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'idgame',
		'location',
		'date',
		'comment',
		'attendance',
		'weather',
		array(
		'header' => 'Home',
		'name'=>'teamsIdteamHome.Name',
		'type'=>'raw',
		//'value'=> 'CHtml::link($data->name,array("zbProjects/show&id=$data->id"))',
		),
		array(
		'header' => 'Visitor',
		'name'=>'teamsIdteamVisiting.Name',
		'type'=>'raw',
		//'value'=> 'CHtml::link($data->name,array("zbProjects/show&id=$data->id"))',
		),
		/*
		'Teams_idteam_visiting',
		'Teams_idteam_home',
		'Division_iddivision_visiting',
		'Division_iddivision_home',
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

	
	

