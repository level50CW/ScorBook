<?php

?>

<h1>Schedule - Import Games</h1>
<div>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'import-schedule-form',
			'enableAjaxValidation'=>false,
		)); ?>
		
		<div class="clear"></div>
		
		<?php echo $form->errorSummary($model); ?>
		
		<div style='text-align: center; position: relative;'>
			<div class="blacktitle">SELECT FILE</div>
			<div class="rowdiv">
				<div class="gray" style="padding-top: 15px; margin: 0; width: 499px; height: auto;" >
					<div style="line-height: 16px; margin-left: 52px; text-align: left; color: #FFFFFF;">Please select Schedule file to import</div>
				</div>
				<div class="gray" style="margin: 0; width: 499px;" >
					<p style="display: inline;"><input id="importschedule" style="line-height: 16px;width:300px;" type="text" disabled="true" placeholder="Choose File"></p>
					<div class="fileUpload btn ">
						<span>Import</span>
						<input type="file" id="file-data" class="upload"/>
						
						<?php
							// echo CHtml::activeFileField($model, 'qqqWWW',array("class"=>"upload"));
							// echo $form->error($model, 'qqqWWW');
							echo $form->textArea($model, 'scheduleData',array("style"=>"display: none;"));
							echo $form->error($model, 'scheduleData');
						?>
					</div>
					
				</div>
				<div class="gray" style="padding-bottom: 15px; margin: 0; width: 499px; height: auto;" >
					<div style="line-height: 16px; margin-left: 52px; text-align: left; color: #FFFFFF;">
					<?php
						if (isset($result) && $result){
							$rows = $model->importedRowsCount;
							echo "Processed $rows rows.";
							$rows++;
							if (!$model->fileImported)
								echo "<br/>File has error in the $rows line: $message.";
						}
					?>
					</div>
				</div>
			</div>
			
			<br/>
			
			<div class="rowdiv">
				<?php
					echo CHtml::submitButton('Save', array("class"=>"save-form-btn" , 'style'=>'margin: -10px 10px 0 0;'));
					echo CHtml::link('Cancel',array('schedule/admin'),array('class'=>'save-form-btn'));
				?>
			</div>

			<?php echo $form->textField($model, 'fileImported',array("style"=>"display: none;", 'value'=>'1')); ?>
			<?php $this->endWidget(); ?>
		</div>
		
		
	</div><!-- form -->
</div>

<script>
(function(){
	$("#file-data").change(function(e){
		var file = e.target.files[0];
		
		var reader = new FileReader();
		reader.onload = function(event) {
			var contents = event.target.result;
			$("#Import_scheduleData").text(contents);
			$("#importschedule").val($("#file-data")[0].value);
		};
		 
		reader.onerror = function(event) {
			alert("Cannot to open file.");
		};
		 
		reader.readAsText(file);
	});
})();
</script>