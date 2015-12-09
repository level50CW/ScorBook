<?php
/* @var $this LeagueController */
/* @var $model League */

function createSeasonInUse(){
	$seasons = Season::model()->findAll();
	$jsArray = '[';
	for($i=0;$i<count($seasons); $i++){
		if (count($seasons[$i]->teams)>0 ||
			count($seasons[$i]->players)>0 ||
			count($seasons[$i]->games)>0)
			$jsArray.=$seasons[$i]->idseason.', ';
	}
	$jsArray .= ']';
	
	echo 'function isSeasonInUse(id){
		return '.$jsArray.'.indexOf(id)!=-1;
	}
	';
}

?>

<h1>Season - Manage Seasons</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'season-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		// 'idleague',
		'season',
		'startdate',
		'enddate',
		array(
			'name'=>'status',
			'value'=>function($data){
				$statusEnum = array(2 => "Completed",1 => "Active",0 => "Future");
				return $statusEnum[$data->status];
			}
		),
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array(
				'delete'=>array(
					'click'=>"function(){
						if (isSeasonInUse(+this.search.split('=').reverse()[0])){
							alert('You can not delete '+$('td',$(this).parent().parent()).first().text()+' season because it is in use.');
						} else {
							if(!confirm( 'Please confirm you want to delete '+$(this).parent().parent().find('td').eq(0).text()+' season.')) return false;
							var th = this;
							var	afterDelete = function(link,success,data){ if(success) {
										alert('Season '+$(link).parent().parent().find('td').eq(0).text()+' has been successfully deleted.');
									} };
							jQuery('#season-grid').yiiGridView('update', {
								type: 'POST',
								url: jQuery(this).attr('href'),
								success: function(data) {
									jQuery('#season-grid').yiiGridView('update');
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
)); ?>

<script>
	<?php createSeasonInUse(); ?>
</script>