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

$buttons = array(
    'header' => 'Actions',
    'class'=> 'CButtonColumn',
    'template'=> '{view}{update}{delete}',
    'afterDelete'=>$deleteAfterDelete,
    'deleteConfirmation'=>$deleteConfirmation
);


switch ($role) {
    case 'admins':
        break;
	case 'leagueadmin':
        break;
	case 'teamadmin':
        $buttons['template'] = '{view}{update}';
        break;
    case 'roster':
        $buttons['template'] = '{view}';
        break;
    default:
        $buttons['filterHtmlOptions'] = array('style' => 'display:none');
        $buttons['headerHtmlOptions'] = array('style' => 'display:none');
        $buttons['htmlOptions'] = array('style' => 'display:none');
        break;
}

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

        $(".js-grid-time").each(function() {
            var date = moment($(this).attr("value")).format("MM-DD-YYYY HH:mm");
            $(this).text(date);
        });

//        if (!!$("#Games_date").val()){
//            var date = moment($("#Games_date").val()+" UTC");
//            $("#Games_date").val(date.format("MM-DD-YYYY HH:mm"));
//            $("#Games_dateUtc").val(date.toISOString());
//        }

        $("#Games_date").on("input",function(){
            if (!!$("#Games_date").val()){
                var date = moment($("#Games_date").val());
                $("#Games_dateUtc").val(date.toISOString());
            }
        });
    })();
';

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
        array(
            'name'=>'date',
            'type' => 'raw',
            'value'=>function($data){
                return '<span class="js-grid-time" value="'
                    .DateTime::createFromFormat("m-d-Y H:i",$data->date)->format(DATE_ISO8601)
                    .'"></span>';
            },
            'filter' => CHtml::activeTextField($model, 'date')
                        .CHtml::activeHiddenField($model, 'dateUtc'),
        ),
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
    'afterAjaxUpdate'=> "function(){ $functionClearFilter }"
)); ?>

<script>
    <?php echo $functionClearFilter; ?>
</script>
    

