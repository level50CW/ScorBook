<?php
/* @var $this DivisionController */
/* @var $model Division */

/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#division-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/

function createDivisionHasTeam(){
	$connection = Yii::app()->db;
	$command = $connection->createCommand('SELECT DISTINCT  `Division_iddivision` FROM  `teams`');
	$row = $command->queryAll();
	
	$jsArray = '[';
	for($i=0;$i<count($row); $i++){
		$jsArray .= $row[$i]['Division_iddivision'].', ';
	}
	$jsArray .= ']';
	
	echo 'function isDivisionHasTeam(id){
		return '.$jsArray.'.indexOf(id)!=-1;
	}
	';
}

?>

<h1>Divisions - Manage Divisions</h1>




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'division-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		//'iddivision',
		'leagueIdleague.Name',
		'Name',
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array(
				'delete'=>array(
					'click'=>"function(){
						if (isDivisionHasTeam(+this.search.split('=').reverse()[0])){
							alert('You can not delete a Division that has Teams assigned. You must first change Division for all assigned Teams.');
						} else {
							if(!confirm( 'Please confirm you want to delete '+$(this).parent().parent().find('td').eq(0).text()+'.')) return false;
							var th = this;
							var	afterDelete = function(link,success,data){ if(success) {
										alert('Division '+$(link).parent().parent().find('td').eq(0).text()+' has been successfully deleted.');
									} };
							jQuery('#division-grid').yiiGridView('update', {
								type: 'POST',
								url: jQuery(this).attr('href'),
								success: function(data) {
									jQuery('#division-grid').yiiGridView('update');
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
	<?php createDivisionHasTeam(); ?>
</script>