<?php
/* @var $this LeagueController */
/* @var $model League */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#league-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Scorebook</h1>
<div>
<!-- 
    <?php if ( Yii::app()->session['role']  == 'admins' ){ ?>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('players/admin'); ?>"><img src="images/rosters.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('games/admin'); ?>"><img src="images/schedule.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('games/create'); ?>"><img src="images/score_game.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('league/admin'); ?>"><img src="images/leagues.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('games/admin'); ?>"><img src="images/statistics.jpg" border="0"/></a> </div>

    <?php }else if(Yii::app()->session['role']  == 'roster'){ ?>
        <div class="score-in"><a href="<?=Yii::app()->createUrl('players/admin'); ?>"><img src="images/rosters.jpg" border="0"/></a> </div>
        <div class="score-in"><a href="<?=Yii::app()->createUrl('games/admin'); ?>"><img src="images/schedule.jpg" border="0"/></a> </div>
    <?php } ?> -->
</div>