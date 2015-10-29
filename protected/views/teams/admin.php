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


function createTeamHasRoster(){
	$connection = Yii::app()->db;
	$command = $connection->createCommand('SELECT DISTINCT  `Teams_idteam` FROM  `players`');
	$row = $command->queryAll();
	
	$jsArray = '[';
	for($i=0;$i<count($row); $i++){
		$jsArray .= $row[$i]['Teams_idteam'].', ';
	}
	$jsArray .= ']';
	
	echo 'function isTeamHasRoster(id){
		return '.$jsArray.'.indexOf(id)!=-1;
	}
	';
}

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
            'name'=>'divisionIddivision.Name',
            'type'=>'raw',
            //'value'=> 'CHtml::link($data->name,array("zbProjects/show&id=$data->id"))',

        ),
		array(
            'name'=>'Name',
			'filter'=> CHtml::activeTextField($model, 'Name',array("placeholder"=>"Search")),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
				'delete'=>array(
					'click'=>"function(){
						if (isTeamHasRoster(+this.search.split('=').reverse()[0])){
							alert('You can not delete a Team that has Players assigned to its Roster. You must first delete or change Team for all assigned Players.');
						} else {
							if(!confirm( 'Please confirm you want to delete '+$(this).parent().parent().find('td').eq(1).text()+'.')) return false;
							var th = this;
							var	afterDelete = function(link,success,data){ if(success) {
										alert('Team '+$(link).parent().parent().find('td').eq(1).text()+' has been successfully deleted.');
									} };
							jQuery('#teams-grid').yiiGridView('update', {
								type: 'POST',
								url: jQuery(this).attr('href'),
								success: function(data) {
									jQuery('#teams-grid').yiiGridView('update');
									afterDelete(th, true, data);
								},
								error: function(XHR) {
									return afterDelete(th, false, XHR);
								}
							});
						}
						return false;
					}"
				)
			),
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

<script>
	<?php createTeamHasRoster(); ?>
</script>