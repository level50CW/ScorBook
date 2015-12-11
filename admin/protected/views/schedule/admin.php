<?php
/* @var $this GamesController */
/* @var $model Games */

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

<h1>Schedule – Manage Games</h1>

<?php 
$role = Yii::app()->session['role'];

$deleteAfterDelete = "function(link,success,data){ if(success) {
				var date = $(link).parent().parent().find('td').eq(2).text().split('  ');
				var visiting = $(link).parent().parent().find('td').eq(3).text();
				var home = $(link).parent().parent().find('td').eq(4).text();
				alert('The Game on '+date[0]+' at '+date[1]+' between '+visiting+' and '+home+' has been deleted.');
			} }";
$deleteConfirmation = "js: (new Date($(this).parent().parent().find('td').eq(1).text())-new Date()>0)?
	'Please confirm you want to delete this game from schedule.':
	'Please confirm you want to delete this game. This game has been played and scored and if deleted all statistics will be lost.'";


switch ($role) {
    case 'admins':
        $buttons = array(
			'header' => 'Actions',
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}{delete}',
			'afterDelete'=>$deleteAfterDelete,
			'deleteConfirmation'=>$deleteConfirmation
        );
        break;
	case 'leagueadmin':
        $buttons = array(
			'header' => 'Actions',
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}{delete}',
			'afterDelete'=>$deleteAfterDelete,
			'deleteConfirmation'=>$deleteConfirmation
        );
        break;
	case 'teamadmin':
        $buttons = array(
			'header' => 'Actions',
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}',
        );
        break;
    case 'roster':
        $buttons = array(
			'header' => 'Actions',
            'class'=> 'CButtonColumn',
            'template'=> '{view}',
        );
        break;
    default:
         $buttons = array(
			'header' => 'Actions',
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}{delete}',
            'filterHtmlOptions' => array('style' => 'display:none'),
            'headerHtmlOptions' => array('style' => 'display:none'),
            'htmlOptions' => array('style' => 'display:none'),
			'afterDelete'=>$deleteAfterDelete,
			'deleteConfirmation'=>$deleteConfirmation
        );
        break;
}

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'games-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
		array(
			'header'=>'League',
			'value'=>'$data->divisionIddivisionHome->leagueIdleague->Name',
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
        'date',
		array(
			'name'=>'teamsIdteamHome.Name',
			'filter'=> CHtml::activeTextField($model, 'teamsIdteamHome_Name')
        ),
		array(
			'name'=>'teamsIdteamVisiting.Name',
			'filter'=> CHtml::activeTextField($model, 'teamsIdteamVisiting_Name')
        ),
        'location',
        /*
        //'idgame',
        'Teams_idteam_visiting',
        'Teams_idteam_home',
        'Division_iddivision_visiting',
        'Division_iddivision_home',
        */
        $buttons
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

    
    

