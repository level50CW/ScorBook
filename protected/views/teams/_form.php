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

function createLeagueSeasonDivisionDependency()
{
	$list= Yii::app()->db->createCommand('SELECT DISTINCT d.`league_idleague`, l.`Name` AS `LN`, g.`season`, d.`iddivision`, d.`Name` AS `DN`
											FROM `games` g
											JOIN `division` d ON d.`iddivision`=g.`Division_iddivision_visiting` OR d.`iddivision`=g.`Division_iddivision_home`
											JOIN `league` l ON l.`idleague`=d.`league_idleague`')->queryAll();
	for($i=0; $i<count($list); $i++){
		$idl = $list[$i]['league_idleague'];
		$nl = $list[$i]['LN'];
		$s = $list[$i]['season'];
		$idd = $list[$i]['iddivision'];
		$nd = $list[$i]['DN'];
		echo "add($idl,'$nl',$s,$idd,'$nd');\n";
	}
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
        <div class="green" style="padding-top:30px;" > League <span class="required">*</span></div>
            <div class="gray" style="padding-top:30px;" >
			<select style="width:216px !important; text-align:center" id="Teams_League_idleague"></select>
			</div>
    </div>
	
	<div class="rowdiv">
        <div class="green"> Season <span class="required">*</span></div>
            <div class="gray">
			<select style="width:216px !important; text-align:center" id="Teams_Season"></select>
			</div>
    </div>

    <div class="rowdiv">
        <div class="green"> Division <span class="required">*</span></div>
            <div class="gray">
            <?php echo $form->dropDownList($model,'Division_iddivision',array(),array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center', 'disabled'=>'disabled')));?>
            <?php echo $form->error($model,'Division_iddivision'); ?>
			<input type="hidden" name="Teams[Division_iddivision]" id="Teams_Division_iddivision_second" value="-1"/>
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
			echo CHtml::submitButton(($model->isNewRecord ? 'Add' : 'Update').'/Next',array("class"=>"save-form-btn", 'style'=>'margin-top: 0;', 'name'=>'next'));
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
    // document.getElementById("Teams_uploadfile").onchange = function () {
        // document.getElementById("uploadFile").value = this.value;
    // };
	
(function(){
	$("#Teams_uploadfile").change(function(){
		$("#uploadFile").val(this.value);
	});
	
	
	var $leagueSelect = $("#Teams_League_idleague");
	var $seasonSelect = $("#Teams_Season");
	var $divisionSelect = $("#Teams_Division_iddivision");
	var counter = 0;
	
	var data = {};
	function add(idleague, leagueName, season, iddivision, divisionName){
		if (!data[idleague])
			data[idleague] = {
				id: idleague,
				name: leagueName,
				divisions: {}
			};
		if (!data[idleague].divisions[season])
			data[idleague].divisions[season] = [];
		data[idleague].divisions[season].push({
			id:iddivision,
			name:divisionName
		})
	}
	<?php
	createLeagueSeasonDivisionDependency();
	echo 'var isUiDisabled='.($disabled? 'true': 'false').';';
	
	if ($model->isNewRecord){
		echo 'var defaultLeague='.Settings::get()->idleague.";\n";
		echo 'var defaultSeason='.Settings::get()->season.";\n";
		echo "var defaultDision=data[defaultLeague].divisions[defaultSeason][0].id;\n";
	} else {
		echo 'var defaultLeague='.$model->divisionIddivision->league_idleague.";\n";
		echo 'var defaultSeason='.Division::model()->getSeason($model->divisionIddivision).";\n";
		echo "var defaultDision=".$model->divisionIddivision->iddivision.";\n";
	}
	
	?>
	
	for(var idl in data){
		var $opt = $("<option>").val(idl).text(data[idl].name).appendTo($leagueSelect);
		if (idl == defaultLeague)
			$opt.prop("selected",1);
		counter++;
	}
	
	$leagueSelect.prop("disabled",counter == 1 || isUiDisabled);
	
	var selectedLeague = 0;
	$leagueSelect.change(function(){
		var id = $("option:selected", this).val();
		selectedLeague = id;
		
		$seasonSelect.children().remove();
		counter = 0;
		for(var s in data[id].divisions){
			var $opt = $("<option>").val(s).text(s).appendTo($seasonSelect);
			if (s == defaultSeason)
				$opt.prop("selected",1);
			counter++;
		}
		$seasonSelect.prop("disabled",counter == 1 || isUiDisabled);
		$seasonSelect.change();
	});
	
	$seasonSelect.change(function(){
		var id = $("option:selected", this).val();
		
		$divisionSelect.children().remove();
		counter = 0;
		for(var i in data[selectedLeague].divisions[id]){
			var $opt = $("<option>")
				.val(data[selectedLeague].divisions[id][i].id)
				.text(data[selectedLeague].divisions[id][i].name).appendTo($divisionSelect);
			if (data[selectedLeague].divisions[id][i].id == defaultDision)
				$opt.prop("selected",1);
			counter++;
		}
		$divisionSelect.prop("disabled",counter == 1 || isUiDisabled);
		$divisionSelect.change();
	});
	
	$divisionSelect.change(function(){
		var id = $("option:selected", this).val();
		$("#Teams_Division_iddivision_second").val(id);
	})
	
	$leagueSelect.change();
})();
</script>