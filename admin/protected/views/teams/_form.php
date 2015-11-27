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
	if (Yii::app()->session['role'] == 'admins' || Yii::app()->session['role'] == 'leagueadmin') {
		$list= Yii::app()->db->createCommand('SELECT DISTINCT l.`idleague`, l.`Name` AS `LN`, d.`iddivision`, d.`Name` AS `DN`
												FROM `division` d
												RIGHT JOIN `league` l ON l.`idleague`=d.`league_idleague`')->queryAll();
	}else if (Yii::app()->session['role'] == 'roster' || Yii::app()->session['role'] == 'teamadmin') {
		$team = Yii::app()->session['team'];
		$list= Yii::app()->db->createCommand('SELECT DISTINCT l.`idleague`, l.`Name` AS `LN`, d.`iddivision`, d.`Name` AS `DN`
										FROM `teams` t
										RIGHT JOIN `division` d ON d.`iddivision`=t.`Division_iddivision`
										RIGHT JOIN `league` l ON l.`idleague`=d.`league_idleague`
										WHERE t.`idteam`='.$team)->queryAll();
	}
								
	for($i=0; $i<count($list); $i++){
		$idl = $list[$i]['idleague'];
		$nl = $list[$i]['LN'];
		$idd = $list[$i]['iddivision']? $list[$i]['iddivision']: 'null';
		$nd = $list[$i]['DN']? $list[$i]['DN']: 'null';
		echo "add($idl,'$nl',$idd,'$nd');\n";
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
	<div class="blacktitle">TEAM INFO</div>
	<div class="rowdiv">
        <div class="green" style="padding-top:30px;" > League <span class="required">*</span></div>
            <div class="gray" style="padding-top:30px;" >
			<select style="width:216px !important; text-align:center" id="Teams_League_idleague"></select>
			</div>
    </div>
	
	<div class="rowdiv">
        <div class="green"> Season <span class="required">*</span></div>
            <div class="gray">
			<?php
				$lowestSeason = $model->isNewRecord? 
					Settings::get()->season: 
					min(+$model->season, Settings::get()->season);
					
				$highestSeason = $model->isNewRecord? 
					Settings::get()->season+2: 
					max(+$model->season, Settings::get()->season+2);
			
				$seasons = array();
				for($s=$highestSeason;$s>=$lowestSeason;$s--){
					$seasons[$s] = $s;
				}
				
				?>
			<?php echo $form->dropDownList($model,'season',$seasons,array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center',
						'options'=>$model->isNewRecord?
							array(Settings::get()->season => array('selected'=>true)) : 
							array())));?>
            <?php echo $form->error($model,'season'); ?>
			</div>
    </div>

    <div class="rowdiv">
        <div class="green"> Division <span class="required">*</span></div>
            <div class="gray">
            <?php echo $form->dropDownList($model,'Division_iddivision',array(),array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
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
        <div class="green" > Team Color  </div>
            <div class="gray">

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
        <div class="green"> Logo  </div>
        <div class="gray">

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

	<div class="rowdiv">
        <div class="green" style="padding-bottom:30px;">Status</div>
            <div class="gray" style="padding-bottom:30px;">
            <?php echo $form->dropDownList($model,'status',array('0'=>'Active', '1'=>'Inactive'),array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model,'status'); ?>
            </div>
    </div>

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
	var $divisionSelect = $("#Teams_Division_iddivision");
	var counter = 0;
	
	var data = {};
	data[""] = {
				id: "",
				name: "Select League",
				divisions: []
			};
	
	
	function add(idleague, leagueName, iddivision, divisionName, idteam, teamName){
		if (!data[idleague]){
			data[idleague] = {
				id: idleague,
				name: leagueName,
				divisions: []
			};
			data[idleague].divisions[""] = {
				id: "",
				name: "Select Division",
				teams: []
			};
		}
		
		if (iddivision == null)
			return;
		
		data[idleague].divisions[iddivision] = {
			id: iddivision,
			name: divisionName,
		};
	}
	
	function updateSelect($obj, data, defaultId){		
		var keys = Object.keys(data);
		if (keys.length == 0)
			return;
		
		keys.unshift(keys.pop());		
		for(var k in keys){
			var i = keys[k];
			var $opt = $("<option>")
				.val(data[i].id)
				.text(data[i].name).appendTo($obj);
			if (data[i].id == defaultId)
				$opt.prop("selected",1);
		}
	}
	
	function createSelectes()
	{
		$leagueSelect.children().remove();
		$divisionSelect.children().remove();
		
		$leagueSelect.prop("disabled",isUiDisabled);
		$divisionSelect.prop("disabled",isUiDisabled);
		
		
		var keys = Object.keys(data);
		keys.unshift(keys.pop());
		for(var k in keys){
			var idl = keys[k];
			var $opt = $("<option>").val(idl).text(data[idl].name).appendTo($leagueSelect);
			if (idl == defaultLeague)
				$opt.prop("selected",1);
		}
		$leagueSelect.prop("disabled",true);
	}
	
	<?php
	createLeagueSeasonDivisionDependency();
	echo 'var isUiDisabled='.($disabled? 'true': 'false').';';
	echo 'var defaultSeason='.Settings::get()->season.";\n";
	
	if ($model->isNewRecord){
		echo 'var defaultLeague='.Settings::get()->idleague.";\n";
		echo 'var defaultDision="";'."\n";
	} else {
		echo 'var defaultLeague='.$model->divisionIddivision->league_idleague.";\n";
		echo "var defaultDision=".$model->divisionIddivision->iddivision.";\n";
	}
	
	?>
	
	createSelectes();
	
	var selectedLeague = 0;
	var selectedSeason = 0;
	$leagueSelect.change(function(){
		var id = $("option:selected", this).val();
		selectedLeague = id;
		
		$divisionSelect.children().remove();
		updateSelect($divisionSelect, data[selectedLeague].divisions, defaultDision);
		$divisionSelect.prop(isUiDisabled);
		$divisionSelect.change();
	});
		
	$divisionSelect.change(function(){
		var id = $("option:selected", this).val();
		$("#Teams_Division_iddivision_second").val(id || "");
	})
		
	$leagueSelect.change();
	
	var defaultLeague=<?php echo Settings::get()->idleague;?>;
	var defaultDision="";
})();
</script>