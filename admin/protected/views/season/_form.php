<?php
/* @var $this SeasonController */
/* @var $model Season */
/* @var $form CActiveForm */

$disabledArray = array();
if( isset($disabled) && $disabled ){
    $disabledArray= array(
        "disabled"=>"disabled",
        "readonly"=>"readonly",
    );
}

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'season-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
	  'afterValidate' => 'js: function(form, data, hasError) {
		  if (!hasError){
			  if ('.$model->isNewRecord.'+0){
				  alert("Season "+$("#Season_season").val()+" successfully Added.");
				  location.href = location.href.replace("create","admin");
			  }else{
				  alert("Season "+$("#Season_season").val()+" successfully Updated.");
				  location.href = location.href.replace("update","admin");
			  }
		  }
	  }'
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<br/>
	<div class="blacktitle">Season</div>

	<div class="rowdiv">

		<div class="green" style="padding-top: 30px">Season <span class="required">*</span></div>
		<div class="gray" style="padding-top: 30px">
			<?php 
			$seasons = array();
			for($s=4+date('Y');$s>=+date('Y')-2;$s--){
				$seasons[+$s] = $s;
			}
			
			echo $form->dropDownList($model, 'season', $seasons, array_merge($disabledArray,array(
					"style"=>"width:216px !important;"))); ?>
			<?php echo $form->error($model,'season'); ?>
		</div>
	</div>
	
	<div class="rowdiv">

    <div class="green">Start Date <span class="required">*</span></div>
		<div class="gray">


			<?php
			if( isset($disabled) && $disabled ){
				echo $form->textField($model, 'startdate', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200)));
			}
			else{
				$this->widget('application.extensions.timepicker.timepicker', array(
					'model' => $model,
					'name' => 'startdate', 
					'options' => array(
						'showOn'=>'focus',
						'showHour'=>false,
						'showMinute'=>false,
						'timeFormat' => '',
						'dateFormat' => 'mm-dd-yy'
					),
				));
			}
			?>

			<?php echo $form->error($model, 'startdate'); ?>
		</div>
	</div>
	
	
	
	<div class="rowdiv">

	<div class="green">End Date <span class="required">*</span></div>
		<div class="gray">


			<?php
			if( isset($disabled) && $disabled ){
				echo $form->textField($model, 'enddate', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200)));
			}
			else{
				$this->widget('application.extensions.timepicker.timepicker', array(
					'model' => $model,
					'name' => 'enddate', 
					'options' => array(
						'showOn'=>'focus',
						'showHour'=>false,
						'showMinute'=>false,
						'timeFormat' => '',
						'dateFormat' => 'mm-dd-yy'
					),
				));
			}
			?>

			<?php echo $form->error($model, 'enddate'); ?>
		</div>
	</div>
	
	<div class="rowdiv">

		<div class="green" style="padding-bottom: 30px">Status <span class="required">*</span></div>
		<div class="gray" style="padding-bottom: 30px">
			<?php 			
			echo $form->dropDownList($model, 'status', array(2 => 'Completed',1 => 'Active',0 => 'Future'), array_merge($disabledArray,array(
					"style"=>"width:216px !important;"))); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	</div>
	
	<br/>
	<div class="rowdiv">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array("class"=>"save-form-btn",'style'=>'margin-top: 0;')); ?>
		<?php echo CHtml::link('Cancel',array('season/admin'),array('class'=>'save-form-btn'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
(function(){
	function updateRange(){
		jQuery('#yw0').datetimepicker('option','minDate', new Date(+$("#Season_season").val(),0,1));
		jQuery('#yw0').datetimepicker('option','maxDate', new Date(+$("#Season_season").val(),11,31));
		jQuery('#yw1').datetimepicker('option','minDate', new Date($("#yw0").val()));
		jQuery('#yw1').datetimepicker('option','maxDate', new Date(+$("#Season_season").val(),11,31));
	}
	
	$("#Season_season").change(function(){
		function defaultDate(){
			return "01-01-"+$("#Season_season").val()+" ";
		}
		
		var date = new Date($(".timepicker").val());
		if (+$(this).val() != date.getFullYear()){
			$("#yw0").val(defaultDate());
			$("#yw1").val(defaultDate());
		}
		
		updateRange();
	});

	$("#yw0").change(function(){
		jQuery('#yw1').datetimepicker('option','minDate', new Date($("#yw0").val()));
		var date = $("#yw0").val();
		date = date.slice(0,date.length-1);
		$("#yw0").val(date);
	});
	
	$("#yw1").change(function(){
		var date = $("#yw1").val();
		date = date.slice(0,date.length-1);
		$("#yw1").val(date);
	});
	
	$("body").ready(function(){
		setTimeout(function(){
			updateRange();
		},10);
	});
})();
</script>