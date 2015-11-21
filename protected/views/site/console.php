<h1>Console</h1>
<br />
<div class="form login-form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'console-form',
	'enableClientValidation'=>false,
)); ?>
	<div>
		<input type="hidden" name="token" value="bfa08a74-fe09-49ff-8282-9c28b26b16bc" />
		<input type="text" name="command" />
		<input type="text" name="p1" />
		<input type="text" name="p2" />
		<input type="text" name="p3" />
		<input type="text" name="p4" />
		<?php
			// bfa08a74-fe09-49ff-8282-9c28b26b16bc
			echo CHtml::submitButton('Send'); 
		?>
	</div>
	
	<div class="row">
		<?php print_r($result) ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->