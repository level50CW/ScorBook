<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<style>
#rememberMe-checkbox{
    width: 8px;
    height: 8px;
    display: inline-block;
    background-color: #FAFFBD;
    border: 2px solid #FAFFBD;
    outline: 1px solid black;
}

#rememberMe-checkbox:hover{
	background-color: #85CAA7;
}

#rememberMe-checkbox[checked], #rememberMe-checkbox[checked]:hover{
	background-color: #0C713F;
}

a{
	color:#FFFFFF;
}

a:hover{
	color:#E8D3B7;
}
</style>

<h1>Login</h1>
<br />
<p style="margin: 0 288px;">Please enter your Username and Password below.</p>

<div class="form login-form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		
	</div>

	<div class="row rememberMe">
		<span id="rememberMe-checkbox"></span>
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::link("Forgot your username or password?", array("site/reset"), array("style"=>"font-size: 12px; font-weight: bold;")); ?>
	</div>
	
	<br/>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login',array('class'=>'save-form-btn')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script>
(function(){
	var $originalRememberMe = $("#LoginForm_rememberMe");
	var $fakeRememberMe = $("#rememberMe-checkbox");
	
	$originalRememberMe.change(function(){
		var res = $originalRememberMe.prop("checked");
		if (res){
			$fakeRememberMe.attr("checked",1)
		} else {
			$fakeRememberMe.removeAttr("checked");
		}
	});
	
	$fakeRememberMe.click(function(){
		$originalRememberMe.click();
	});
	
	$originalRememberMe.change().hide();
})();
</script>