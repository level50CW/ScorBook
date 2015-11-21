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
	echo '<p style="margin: 0 288px;">Your username is the email entered when account created.</p>';
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
			
				if ($result == "nouser"){
					echo '<label style="color: #FF7B7B;">That email is not valid. Please, enter another email.</label>';
					echo '<input type="text" name="username" style="    width: 303px;"/>';
					echo '<label>If you forgot username, please enter your security code and press Reset to retrieve email.</label>';
					echo '<input type="text" name="code" style="    width: 303px;"/>';
				}
				
				if ($result == "nocode"){
					echo '<label>Please enter your email and we will check if valid.</label>';
					echo '<input type="text" name="username" style="    width: 303px;"/>';
					echo '<label style="color: #FF7B7B;">That security code is not valid Please, enter another security code.</label>';
					echo '<input type="text" name="code" style="    width: 303px;"/>';
				}
				
				if ($result == "username"){
					echo '<label>Your username <b style="color: #EAC495;">'.$username.'</b>. Enter it to reset your password or try to login.</label>';
					echo '<input type="text" name="username" style="    width: 303px;"/>';
				}
				
				if ($result == ""){
					echo '<label>Please enter your email and we will check if valid.</label>';
					echo '<input type="text" name="username" style="    width: 303px;"/>';
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