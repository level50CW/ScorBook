<style>
label{
	text-align: left;
}
.login-form {
    width: 324px;
}
.login-form .save-form-btn {
    margin: 0 10px;
}
</style>

<h1>Reset password</h1>
<br />

<?php
if ($result == "" || $result == "nouser")
	echo '<p style="margin: 0 288px;">New password will be sent on you email.</p>';
?>

<div class="form login-form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
)); ?>
	<div  style='position: relative;'>
		<div class="row">
			<?php
				if ($result == "success"){
					echo '<label style="text-align: center;">Password successfully reset.<br/>New password have been sent on you email.</label>';
				}
			
				if ($result == "" || $result == "nouser"){
					echo '<label>Enter your email</label>';
					echo '<input type="text" name="username" style="    width: 303px;"/>';
					if ($result == "nouser")
						echo '<label style="color: #FF7B7B;">User is not registered. Please, enter another email.</label>';
				}
				
				
			?>
		</div>
		
		<div class="rowdiv">
			<?php
				if ($result != "success")
					echo CHtml::submitButton('Reset', array("class"=>"save-form-btn" , 'style'=>'    margin: -10px 0px 0 0;'));
				echo CHtml::link('Cancel',array('site/login'),array('class'=>'save-form-btn'));
			?>
		</div>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->