<?php
$disabledArray = array();
$disabledConfirm = false;
if( isset($disabled) && $disabled ){
    $disabledArray= array(
        "disabled"=>"disabled",
        "readonly"=>"readonly",
    );
	$disabledConfirm = true;
}
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
	  'afterValidate' => 'js: function(form, data, hasError) {
		  if (!hasError){
			  if ('.$model->isNewRecord.'+0){
				  alert("User "+$("#Users_Firstname").val()+" "+$("#Users_Lastname").val()+" successfully Added.");
			  }else{
				  alert("User "+$("#Users_Firstname").val()+" "+$("#Users_Lastname").val()+" successfully Updated.");
			  }
			  return true;
		  }
	  }'
	  )
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



<div class="blacktitle"> USER INFO</div>
    <div class="rowdiv">
        <div class="green">First Name<span class="required">*</span></div>
        <div class="gray">
        <?php echo $form->textField($model,'Firstname',array_merge($disabledArray,array('size'=>45,'maxlength'=>45))); ?>
        <?php echo $form->error($model,'Firstname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green">Last Name<span class="required">*</span></div>
        <div class="gray">
        <?php echo $form->textField($model,'Lastname',array_merge($disabledArray,array('size'=>45,'maxlength'=>45))); ?>
        <?php echo $form->error($model,'Lastname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green">Email<span class="required">*</span></div>
        <div class="gray">
        <?php echo $form->textField($model,'Email',array_merge($disabledArray,array('size'=>60,'maxlength'=>150))); ?>
        <?php echo $form->error($model,'Email'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green">Password<span class="required">*</span></div>
        <div class="gray">
        <?php echo $form->passwordField($model,'Password',array_merge($disabledArray,array('size'=>35,'maxlength'=>35))); ?>
        <?php echo $form->error($model,'Password'); ?>
        </div>
    </div>
	
	<div class="rowdiv">
        <div class="green">Confirm<span class="required">*</span></div>
        <div class="gray">
		<input id="Users_Confirm" type="password" size="35" maxlength="35" <?php echo $disabledConfirm ? 'disabled="disabled"':''?>/>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green">Team Name<span class="required">*</span></div>
        <div class="gray">
           <?php
            $teams     = Teams::model()->findAll();
            $listTeams = CHtml::listData($teams,'idteam', 'Name');?>
            <?php echo $form->dropDownList($model,'Teams_idteam',$listTeams,array_merge($disabledArray,array('empty' => 'Select Team','style' => 'width:216px !important; text-align:center'))); ?>
            <?php echo $form->error($model,'Teams_idteam'); ?>
        </div>
    </div>

	<div class="rowdiv">
        <div class="green">Role<span class="required">*</span></div>
        <div class="gray">
        <?php echo $form->dropDownList($model, 'role', array('scorer' => 'Scorekeeper', 'admins' => 'League Admin','roster' => 'Team Admin'),array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center'))); ?>
        </div>
    </div>
	
</div>
<br/>

<div class="rowdiv">
    <?php if( isset($disabled) && $disabled ){
        echo CHtml::link('Close',array('users/admin', 'Users_page'=>isset(Yii::app()->session['Users_page']) ? Yii::app()->session['Users_page'] : 1),array('class'=>'save-form-btn'));
    }
    else{
        echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array("class"=>"save-form-btn" , 'style'=>'margin: -10px 10px 0 0;', "onClick"=>
		'
		if ($("#Users_Password").val()=="'.$model->Password.'") return true;
		
		if ($("#Users_Password").val()!=$("#Users_Confirm").val()){
			alert("The passwords you entered do not match");
			return false;
		}
		if ($("#Users_Password").val().match(/^(?=.*[a-z])(?=.*[A-Z])[a-zA-Z_$%-]{8,16}$/) == null){
			alert("You have entered an invalid password. Passwords must have between 8 and 16 characters with at least 1 uppercase and 1 lowercase letter. The only special characters allowed are $, %, - and _.");
			return false;
		}
		return true;
		'));
        echo CHtml::link('Cancel',array('users/admin', 'Users_page'=>isset(Yii::app()->session['Users_page']) ? Yii::app()->session['Users_page'] : 1),array('class'=>'save-form-btn'));
    } ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
