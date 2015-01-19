<?php
/* @var $this TeamsController */
/* @var $model Teams */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#teams-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Teams - Manage Teams</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'teams-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        //'idteam',
        array(
            'header' => 'Division',
            'name'=>'leagueIdleague.Name',
            'type'=>'raw',
            //'value'=> 'CHtml::link($data->name,array("zbProjects/show&id=$data->id"))',

        ),
		array(
            'name'=>'Name',
			'filter'=> CHtml::activeTextField($model, 'Name',array("placeholder"=>"Search")),
        ),
        array(
            'class'=>'CButtonColumn',
            'deleteConfirmation'=>"js: 'Are you sure you want to delete this Team?'"
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
