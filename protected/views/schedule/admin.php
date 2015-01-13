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
switch ($role) {
    case 'admins':
        $buttons = array(
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}{delete}',
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
        );
        break;
    default:
         $buttons = array(
            'class'=> 'CButtonColumn',
            'template'=> '{view}{update}{delete}',
            'filterHtmlOptions' => array('style' => 'display:none'),
            'headerHtmlOptions' => array('style' => 'display:none'),
            'htmlOptions' => array('style' => 'display:none'),
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
        'League_idleague_visiting',
        'League_idleague_home',
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

    
    

