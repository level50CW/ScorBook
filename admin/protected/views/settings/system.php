<?php
?>

<h1>Settings</h1>
<div>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'system-settings-form',
			'enableAjaxValidation'=>false,
			'clientOptions' => array(
			  'validateOnSubmit' => true,
			  'validateOnChange' => false,
			  'afterValidate' => 'js: function(form, data, hasError) {
				  if (!hasError){
					  alert("Settings successfully applied.");
					  return true;
				  }
			  }'
			  )
		)); ?>
		
		<div class="clear"></div>

		<div style='text-align: center; position: relative;'>
			<?php echo $form->errorSummary($model); ?>
			<div class="blacktitle">SYSTEM SETTINGS</div>
			<div class="rowdiv">
				<div class="green" style="padding-top:30px;" >DB URL</div>
				<div class="gray" style="padding-top:30px;" >
					<?php echo $form->textField($model,'databaseUrl',array('size'=>160,'maxlength'=>150));?>
					<?php echo $form->error($model,'databaseUrl'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green">Username</div>
				<div class="gray">
					<?php echo $form->textField($model,'databaseUsername',array('size'=>60,'maxlength'=>150));?>
					<?php echo $form->error($model,'databaseUsername'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green">Password</div>
				<div class="gray">
					<?php echo $form->passwordField($model,'databasePassword',array('size'=>60,'maxlength'=>150));?>
					<?php echo $form->error($model,'databasePassword'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green">Confirm</div>
				<div class="gray">
					<?php echo $form->passwordField($model,'databaseConfirm',array('size'=>60,'maxlength'=>150));?>
					<?php echo $form->error($model,'databaseConfirm'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green"></div>
				<div class="gray">
					<label style="position: relative; top: 20px; color: white;">Enter your password to save changes</label>
				</div>
			</div>			
			<div class="rowdiv">
				<div class="green" style="padding-bottom:30px;">Unlock</div>
				<div class="gray" style="padding-bottom:30px;">
					<?php echo $form->passwordField($model,'adminPassword',array('size'=>60,'maxlength'=>150));?>
					<?php echo $form->error($model,'adminPassword'); ?>
				</div>
			</div>
			
			<?php echo $form->hiddenField($model,'databasePasswordChanged',array('size'=>60,'maxlength'=>150));?>
			<br />

			<div class="rowdiv">
				<?php
					echo CHtml::submitButton('Save', array("class"=>"save-form-btn" , 'style'=>'margin: -10px 10px 0 0;'));
					echo CHtml::link('Cancel',array('principal/admin'),array('class'=>'save-form-btn'));
				?>
			</div>

			<?php $this->endWidget(); ?>
		</div>
	</div><!-- form -->
</div>

<script>
(function(){
	$("#SystemSettings_databasePassword").change(function(){
		$("#SystemSettings_databasePasswordChanged").val($(this).val());
	});
})();
</script>