<?php
/* @var $this DivisionController */
/* @var $model Division */


Yii::app()->clientScript->registerScript('search', "
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
");
?>

<h1>ScoreBook Administration</h1>
<div>
<!-- 
    <?php if ( Yii::app()->session['role']  == 'admins' ){ ?>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('players/admin'); ?>"><img src="images/rosters.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('games/admin'); ?>"><img src="images/schedule.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('games/create'); ?>"><img src="images/score_game.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('division/admin'); ?>"><img src="images/divisions.jpg" border="0"/></a> </div>
    <div class="score-in"><a href="<?=Yii::app()->createUrl('games/admin'); ?>"><img src="images/statistics.jpg" border="0"/></a> </div>

    <?php }else if(Yii::app()->session['role']  == 'roster'){ ?>
        <div class="score-in"><a href="<?=Yii::app()->createUrl('players/admin'); ?>"><img src="images/rosters.jpg" border="0"/></a> </div>
        <div class="score-in"><a href="<?=Yii::app()->createUrl('games/admin'); ?>"><img src="images/schedule.jpg" border="0"/></a> </div>
    <?php } ?> -->
</div>