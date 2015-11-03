<?php
$leagues = League::model()->findAll();
$listLeagues = CHtml::listData($leagues,'idleague', 'Name');

$seasons = array(
	(4+date('Y'))=>(4+date('Y')),
	(3+date('Y'))=>(3+date('Y')),
	(2+date('Y'))=>(2+date('Y')),
	(1+date('Y'))=>(1+date('Y')),
	(0+date('Y'))=>(0+date('Y')),
	(-1+date('Y'))=>(-1+date('Y')),
);

$months = cal_info(0);
$months = $months['months'];
$listSize = array('100'=>100,'75'=>75,'50'=>50,'25'=>25,'10'=>10);
?>

<h1>Settings</h1>
<div>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'general-settings-form',
			'enableAjaxValidation'=>true,
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

			<div class="rowdiv">
				<div class="green" style="padding-top:30px;" >League</div>
				<div class="gray" style="padding-top:30px;" >
					<?php echo $form->dropDownList($model,'idleague',$listLeagues,array('empty' => 'Select Division','style' => 'width:216px !important; text-align:center'));?>
					<?php echo $form->error($model,'idleague'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green">Season</div>
				<div class="gray">
					<?php echo $form->dropDownList($model,'season',$seasons,array('style' => 'width:216px !important; text-align:center'));?>
					<?php echo $form->error($model,'season'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green">Season Start Month</div>
				<div class="gray">
					<?php echo $form->dropDownList($model,'monthStart',$months,array('style' => 'width:216px !important; text-align:center'));?>
					<?php echo $form->error($model,'monthStart'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green">Season End Month</div>
				<div class="gray">
					<?php echo $form->dropDownList($model,'monthEnd',$months,array('style' => 'width:216px !important; text-align:center'));?>
					<?php echo $form->error($model,'monthEnd'); ?>
				</div>
			</div>
			<div class="rowdiv">
				<div class="green" style="padding-bottom:30px;">Max List Size</div>
				<div class="gray" style="padding-bottom:30px;">
					<?php echo $form->dropDownList($model,'listSize',$listSize,array('style' => 'width:216px !important; text-align:center'));?>
					<?php echo $form->error($model,'listSize'); ?>
				</div>
			</div>
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
	var monthNames = ["","January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"];
	$("#Settings_monthStart").change(function(){
		var lastStartMonth = +$("option:selected",this).val();
		var lastEndMonth = +$("option:selected","#Settings_monthEnd").val();
		var lastEndMonth = Math.max(lastEndMonth, lastStartMonth);
		$("#Settings_monthEnd").children().remove();
		for (var i = lastStartMonth; i<=12; i++){
			$("#Settings_monthEnd").append($("<option>").val(i).text(monthNames[i]));
		}
		$("option","#Settings_monthEnd").eq(lastEndMonth - lastStartMonth).prop("selected",1);
	});
	
	$("#Settings_monthStart").change();
})();
</script>