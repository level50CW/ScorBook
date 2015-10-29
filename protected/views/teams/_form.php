<?php
/* @var $this TeamsController */
/* @var $model Teams */
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
    'id'=>'teams-form',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
	  'afterValidate' => 'js: function(form, data, hasError) {
		  if (!hasError){
			  if ('.$model->isNewRecord.'+0){
				  alert("Team "+$("#Teams_Name").val()+" successfully Added.");
			  }else{
				  alert("Team "+$("#Teams_Name").val()+" successfully Updated.");
			  }
			  return true;
		  }
	  }'
	  )
)); ?>

<div class="clear"></div>

<div style='text-align: center; position: relative;'>

    <?php echo $form->errorSummary($model); ?>

    <?php
        $divisions = Division::model()->findAll();
        $listDivision = CHtml::listData($divisions,'iddivision', 'Name');
    ?>

    <div class="rowdiv">
        <div class="green" style="padding-top:30px;" > Division <span class="required">*</span></div>
            <div class="gray" style="padding-top:30px;" >
            <?php echo $form->dropDownList($model,'Division_iddivision',$listDivision,array_merge($disabledArray,array('empty' => 'Select Division','style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model,'Division_iddivision'); ?>
            </div>
    </div>

    <div class="rowdiv">
        <div class="green" > Team Name <span class="required">*</span></div>
            <div class="gray" >
        <?php echo $form->textField($model,'Name',array_merge($disabledArray,array('size'=>60,'maxlength'=>100))); ?>
        <?php echo $form->error($model,'Name'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"  > Name Abbrev <span class="required">*</span></div>
            <div class="gray" >
        <?php echo $form->textField($model,'Abv',array_merge($disabledArray,array('size'=>60,'maxlength'=>100))); ?>
        <?php echo $form->error($model,'Abv'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"  >Stadium <span class="required">*</span></div>
            <div class="gray" >
        <?php echo $form->textField($model,'location',array_merge($disabledArray,array('size'=>60,'maxlength'=>100))); ?>
        <?php echo $form->error($model,'location'); ?>
        </div>
    </div>


    <div class="rowdiv">
        <div class="green" <?php echo isset($disabled) ? 'style="padding-bottom:30px;"' : ''; ?> > Team Color  </div>
            <div class="gray" <?php echo isset($disabled) ? 'style="padding-bottom:30px;"' : ''; ?> >

    <?php

    if( isset($disabled) && $disabled ){
        echo $form->textField($model,'RGB',array_merge($disabledArray,array('size'=>60,'maxlength'=>100)));
    }
    else{
    $this->widget('application.extensions.colorpicker.EColorPicker',
              array(
                    'name'=>'RGB',
                    'mode'=>'textfield',
                    'value'=> $model->RGB,
                    'fade' => false,
                    'slide' => false,
                    'curtain' => true,
                   )
             );
    }
    ?>
        </div>
    </div>



    <?php if( !isset($disabled)  ){ ?>
    <div class="rowdiv">
        <div class="green"  <?php echo !isset($disabled) ? 'style="padding-bottom:30px;"' : ''; ?>> Logo  </div>
        <div class="gray" <?php echo !isset($disabled) ? 'style="padding-bottom:30px;position:relative"' : ''; ?>>

            <div class="fileUpload btn ">
                <span>Upload</span>
               <!--  <input id="uploadfile" type="file" class="upload" /> -->
                <?php
                    echo $form->fileField($model, 'uploadfile',array("class"=>"upload"));
                    echo $form->error($model, 'uploadfile');
                ?>
            </div>
            <p style="display: inline;"><input id="uploadFile" style="line-height: 16px;width:122px;" type="text" disabled="disabled" placeholder="Choose File"></p>



<!-- 
            <div class="upload">
            <?php
                //echo $form->fileField($model, 'uploadfile');
                //echo $form->error($model, 'uploadfile');
            ?>
            </div> -->
        </div>
    </div>
    <?php } ?>


<br />
    <div class="rowdiv">
        <?php if( isset($disabled) && $disabled ){
			echo CHtml::link('Close',array('teams/admin','Teams_page'=>isset(Yii::app()->session['Teams_page']) ? Yii::app()->session['Teams_page'] : 1),array('class'=>'save-form-btn'));
        }
        else{
            echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array("class"=>"save-form-btn",'style'=>'margin-top: 0;'));
            echo "&nbsp;";
			echo CHtml::link('Cancel',array('teams/admin','Teams_page'=>isset(Yii::app()->session['Teams_page']) ? Yii::app()->session['Teams_page'] : 1),array('class'=>'save-form-btn'));
        } ?>
    </div>




    <div class='teamphoto'>
    <? if ($model->logo) { ?>
    <?php $this->beginWidget('application.extensions.thumbnailer.Thumbnailer', array(
                                        'thumbsDir' => 'images/thumbs',
                                        'thumbWidth' => 125,
                                        //'thumbHeight' => 150, // Optional
                                    )
                                ); ?>
    <img src="images/team_logo/<?php echo $model->thumb?>"/>
    <?php $this->endWidget(); ?>
    <?}
    ?>
    </div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->

<script>
    document.getElementById("Teams_uploadfile").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };
</script>