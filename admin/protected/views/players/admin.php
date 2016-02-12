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

$functionClearFilter = '
    (function(){
        $(".filters td").last().append(
            $("<a>")
                .attr("href","#")
                .addClass("ui-clear-button")
                .text("Clear")
                .click(function(){
                    $(".filters input, .filters select")
                        .val(null)
                        .first().change();
                }));
    })();
';

?>

<h1>Team Rosters - Manage Players & Coaches</h1>
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
			'header'=>'League',
			'name'=>'teamsIdteam.divisionIddivision.leagueIdleague.Name',
			'filter' => '',
		),
		array(
            'header'=>'Season',
			'value'=>'$data->season->season',
			'filter' => CHtml::activeDropDownList($model, 'season_idseason',
				CHtml::listData(Season::model()->findAll(), 'idseason', 'season'),
				array(
					'empty' => 'Select',
					'style'=>'color: black; padding-top: 0px; border: 1px solid #8CB8E7 !important;')),
        ),
		array(
			'header'=>'Division',
			'name'=>'teamsIdteam.divisionIddivision.Name',
			'filter' => CHtml::activeDropDownList($model, 'division_Name',
				CHtml::listData(Division::model()->findAll(), 'iddivision', 'Name'),
				array(
					'empty' => 'Select',
					'style'=>'color: black; padding-top: 0px; border: 1px solid #8CB8E7 !important;')),
		),
		
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
			'header'=>'Actions',
			'afterDelete'=>"function(link,success,data){ if(success) {
				alert('Player '+$(link).parent().parent().find('td').eq(4).text()+', '+$(link).parent().parent().find('td').eq(5).text()+' deleted.')
			} }",
			'deleteConfirmation'=>"js: 'Please Confirm you want to delete '+$(this).parent().parent().find('td').eq(4).text()+', '+$(this).parent().parent().find('td').eq(5).text()+'. Remember deleting a player loses forever their statistics'"
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
	'afterAjaxUpdate'=> "function(){ $functionClearFilter }"
)); ?>
<script>
	<?php echo $functionClearFilter; ?>
</script>