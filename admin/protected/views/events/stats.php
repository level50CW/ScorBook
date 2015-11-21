<?php 
	$title = 'BOX SCORE - ' . Yii::app()->user->getState('teamhome') . ' VS ' . Yii::app()->user->getState('teamvisiting');
?>
<h1> <?php echo $title;?> </h1>

<script>
	//document.getElementById("container").style.width = "1200px";
	document.getElementById("content").style.width = "1100px";
	document.getElementById("page").style.width = "1200px";
</script>


<table>
	<tr>
		
		<td >
			<div class="score_button_div1">
			<?php $scoreteam = Yii::app()->user->getState('scoreteam'); ?>
			<?php echo CHtml::button('HOME', array('onclick' => "submitLink('scorehome')",'class'=> ($scoreteam=='home') ?  'score_button_red' :  'score_button'  )); ?>
			<?php echo CHtml::button('VISITORS', array('onclick' => "submitLink('scorevisiting')","class"=> ($scoreteam=='visiting') ?  'score_button_red' :  'score_button'  ,'style'=>'	margin-left: -5px !important;')); ?>
			</div>
		</td>
		<td >
			<div class="score_button_div2">
			<?php $scoretime = Yii::app()->user->getState('scoretime');?>
			<?php echo CHtml::button('SEASON', array('onclick' => "submitLink('scoreseason')","class"=>($scoretime=='season') ?  'score_button_red' :  'score_button'  )); ?>
			<?php echo CHtml::button('GAME', array('onclick' => "submitLink('scoregame')","class"=>($scoretime=='game') ?  'score_button_red' :  'score_button'  ,'style'=>'	margin-left: -5px !important;')); ?>
			<?php echo CHtml::button('SITUATION', array('onclick' => "submitLink('scoregame')","class"=>($scoretime=='situation') ?  'score_button_red' :  'score_button'  ,'style'=>'	margin-left: -5px !important;')); ?>
			</div>
		</td>
		<td >
			<div class="score_button_div2">
			<?php $scoretype = Yii::app()->user->getState('scoretype'); ?>
			<?php echo CHtml::button('BATTING', array('onclick' => "submitLink('scorebatting')","class"=> ($scoretype=='batting') ?  'score_button_red' :  'score_button'  )); ?>
			<?php echo CHtml::button('FIELDING', array('onclick' => "submitLink('scorefielding')","class"=> ($scoretype=='fielding') ?  'score_button_red' :  'score_button' ,'style'=>'	margin-left: -5px !important;')); ?>
			<?php echo CHtml::button('PITCHING', array('onclick' => "submitLink('scorepitching')","class"=> $scoretype=='pitching' ?  'score_button_red' :  'score_button','style'=>'	margin-left: -5px !important;')); ?>
			</div>
			</td>
	</tr>
	
	
</table>


<div id="redbar"></div>
<script>
	$("#span-23").css('display','none');
</script>

<?php echo $this->renderPartial('_stats', array('model'=>$model)); ?>

