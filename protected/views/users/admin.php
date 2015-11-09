<?php
/* @var $this UsersController */
/* @var $model Users */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

switch (Yii::app()->session['role']) {
    case 'admins':
        $template='{view}{update}{delete}';
        break;
	case 'leagueadmin':
        $template='{view}{update}{delete}';
        break;
	case 'teamadmin':
        $template='{view}{update}{delete}';
        break;
    case 'roster':
        $template='{view}{update}';
        break;
    default:
        $template='';
        break;
}
?>

<h1>Users - Manage Users</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'iduser',
		array(
			'header'=>'League',
			'name'=>'teamsIdteam.divisionIddivision.leagueIdleague.Name',
			'filter' => CHtml::activeDropDownList($model, 'leagueIdleague_Name',
				CHtml::listData(League::model()->findAll(), 'idleague', 'Name'),
				array(
					'empty' => 'Select',
					'style'=>'color: black; padding-top: 0px; border: 1px solid #8CB8E7 !important;')),
		),
		array(
			'header'=>'Division',
			'name'=>'teamsIdteam.divisionIddivision.Name',
			'filter' => CHtml::activeDropDownList($model, 'division_Name',
				CHtml::listData(
					$model->leagueIdleague_Name? 
						Division::model()->findAll('`league_idleague`='.$model->leagueIdleague_Name) : 
						Division::model()->findAll(), 
					'iddivision', 'Name'),
				array(
					'empty' => 'Select',
					'style'=>'color: black; padding-top: 0px; border: 1px solid #8CB8E7 !important;')),
		),
        'Lastname',
		'Firstname',
		'Email',
		//'Password',
		'role',
		// array(
			// 'name' => 'role',
			// 'value' => function($data){
				// $roles = array(
					// 'admins' => 'System Admin',
					// 'leagueadmin' => 'League Admin',
					// 'teamadmin' => 'Team Admin',
					// 'roster' => 'Team Roster Admin',
					// 'scorer' => 'Scorekeeper',
					// 'user' => 'User'
				// );
				// return $roles[$data->role];
			// },
			// 'filter' => CHtml::activeTextField($model, 'role')
		// ),		
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'template'=>$template,
			'afterDelete'=>"function(link,success,data){ if(success) {
				alert('User '+$(link).parent().parent().find('td').eq(2).text()+' has been successfully deleted.')
			} }",
			'deleteConfirmation'=>"js: 'Please confirm you want to delete '+$(this).parent().parent().find('td').eq(2).text()+'.'"
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
