<?php
/* @var $this GamesController */
/* @var $model Games */
/* @var $form CActiveForm */
?>

<script>
	$("#span-23").css('display','none');
</script>


<div class="form">

<?

if ( !$model->last_inning )
	$model->last_inning =  Yii::app()->user->getState('inning');
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'games-form',
	'enableAjaxValidation'=>false,
)); ?>
	
	<div class="row">
		<?php echo $form->hiddenField($model,'idgame'); ?>
		<?php echo $form->error($model,'idgame'); ?>
	</div>

	
	
	<div class="clear"></div>
	
	<div class="blacktitle"> FINALIZE GAME	 </div>
	<div class="rowdiv">
		
		<div class="green"> Status  </div>
		<div class="gray">
			<?php echo $form->dropDownList($model,'status',array('1'=>' in progress', '2'=>' End-regulation', '3'=>'End-extraInnings', '4'=>' End-timeLimit', 
				'5'=>'End-runRule', '6'=>'End-forfeit', '7'=>' End-darkness', '8'=>' End-rainOut', '9'=>' End-other', '10'=>' Suspended - Darkness', '11'=>' Suspended-rain', '12'=>' Suspended-other'));?>
			
			
			<?php echo $form->error($model,'date'); ?>
		</div>
	</div>
	
	<div class="rowdiv">
		
		<div class="green"> End date  </div>
		<div class="gray">
			<?php 
			$this->widget('application.extensions.timepicker.timepicker', array(
                'model' => $model,
                'name' => 'end_date', 
                'options' => array(
                    'showOn'=>'focus',
                ),
            ));
			?>
			
			<?php echo $form->error($model,'end_date'); ?>
		</div>
	</div>
	
	
	
	<div class="rowdiv">
		
		<div class="green"> Winning team  </div>
		<div class="gray">
			<?php echo $form->dropDownList($model,'winning_team',array('Visitors'=>'Visitors', 'Home'=>'Home', 'Tie'=>'Tie'));?>
			<?php echo $form->error($model,'winning_team'); ?>
		</div>
	</div>

	<div class="rowdiv">
		
		<div class="green"> Regulation </div>
		<div class="gray">
			<?php echo $form->dropDownList($model,'regulation',array('6'=>'6', '7'=>'7', '9'=>'9 Inning'), array('empty' => '',
'options'=>array('9'=>array('selected'=>'selected'))
));?>
			<?php echo $form->error($model,'regulation'); ?>
		</div>
	</div>
	
	<div class="rowdiv">

	<div class="rowdiv">
		
		<div class="green"> Last inning </div>
		<div class="gray">
			<?php echo $form->textfield($model,'last_inning',array('readonly' => true));?>
			<?php echo $form->error($model,'last_inning'); ?>
		</div>
	</div>
	
	<div class="green"> Half inning </div>
		<div class="gray">
			<?php echo $form->dropDownList($model,'half_inning',array('Top'=>'Top', 'Bottom'=>'Bottom'));?>
			<?php echo $form->error($model,'half_inning'); ?>
		</div>
	</div>
	<?
	echo CHtml::hiddenField('link','',array('id'=>'link'));
	?>
	<br>
	
	<div class="clear"></div>
	<div class="blacktitle"> PITCHERS  </div>
	<div class="rowdiv">
		<div class="brown"> Plate Ump  </div>
		<div class="gray">
			<?php echo $form->textField($model,'Plateump',array('size'=>60,'maxlength'=>200)); ?>
			<?php echo $form->error($model,'Plateump'); ?>
		</div>
	</div>
	<div class="rowdiv">
		<div class="brown"> Field Ump  </div>
		<div class="gray">
			<?php echo $form->textField($model,'Fieldump1',array('size'=>60,'maxlength'=>200)); ?>
			<?php echo $form->error($model,'Fieldump1'); ?>
		</div>
	</div>
	
	<div class="clear"></div>
	
	<div class='redbar' style='height:37px'>
	
		<div  style='text-align: center; margin-top: -4px'>
			<?php echo CHtml::Button('Finalize', array('class'=>'bottom_button_red','onClick'=>'submitLink("gamescreate")')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->