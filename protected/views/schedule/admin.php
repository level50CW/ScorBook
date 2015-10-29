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
				alert('Game between '+$(link).parent().parent().find('td').eq(2).text()+' and '+$(link).parent().parent().find('td').eq(3).text()+' has been successfully deleted.')
			} }";
$deleteConfirmation = "js: (new Date($(this).parent().parent().find('td').eq(1).text())-new Date()>0)?
	'Please confirm you want to delete this game from schedule.':
	'Please confirm you want to delete this game. This game has been played and scored and if deleted all statistics will be lost.'";


switch ($role) {
    case 'admins':
        $buttons = array(
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}{delete}',
			'afterDelete'=>$deleteAfterDelete,
			'deleteConfirmation'=>$deleteConfirmation
        );
        break;
    case 'roster':
        $buttons = array(
            'class'=> 'CButtonColumn',
            'template'=> '{view}',
        );
        break;
    case 'scorer':
        $buttons = array(
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}{delete}',
            'filterHtmlOptions' => array('style' => 'display:none'),
            'headerHtmlOptions' => array('style' => 'display:none'),
            'htmlOptions' => array('style' => 'display:none'),
			'afterDelete'=>$deleteAfterDelete,
			'deleteConfirmation'=>$deleteConfirmation
        );
        break;
    default:
         $buttons = array(
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
        'season',
        'date',
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

    
    

