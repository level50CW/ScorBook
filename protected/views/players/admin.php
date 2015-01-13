<?php
/* @var $this PlayersController */
/* @var $model Players */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#players-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1>Rosters – Manage Players</h1>
<!--
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div> search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'players-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'idplayer',
		array(
		'name'=>'teamname',
		'value'=>'isset($data->teamsIdteam->Name) ? $data->teamsIdteam->Name : ""',
		), 
		'Lastname',
		'Firstname',
		'Number',
		
		//'teamsIdteam.Name',
		'Position',
		/*
		'Bats',
		'Throws',
		*/
		array(
			'class'=>'CButtonColumn',
			'afterDelete'=>'function(link,success,data){ if(success) {
				alert("Player deleted.")
			} }',
			'deleteConfirmation'=>"js: 'Please Confirm you want to delete '+$(this).parent().parent().find('td').eq(1).text()+', '+$(this).parent().parent().find('td').eq(2).text()+'. Remember deleting a player loses forever their statistics'"
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
