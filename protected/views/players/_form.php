<?php
/* @var $this PlayersController */
/* @var $model Players */
/* @var $form CActiveForm */

$disabledArray = array();
if( isset($disabled) && $disabled ){
    $disabledArray= array(
        "disabled"=>"disabled",
        "readonly"=>"readonly",
    );
}

function createLeagueSeasonDivisionTeamDependency()
{
	$list= Yii::app()->db->createCommand('SELECT DISTINCT d.`league_idleague`, l.`Name` AS `LN`, g.`season`, d.`iddivision`, d.`Name` AS `DN`, t.`idteam`, t.`Name` AS TN
											FROM `games` g
											JOIN `division` d ON d.`iddivision`=g.`Division_iddivision_visiting` OR d.`iddivision`=g.`Division_iddivision_home`
											JOIN `league` l ON l.`idleague`=d.`league_idleague`
											JOIN `teams` t ON t.`Division_iddivision`=d.`iddivision`')->queryAll();
	for($i=0; $i<count($list); $i++){
		$idl = $list[$i]['league_idleague'];
		$nl = $list[$i]['LN'];
		$s = $list[$i]['season'];
		$idd = $list[$i]['iddivision'];
		$nd = $list[$i]['DN'];
		$idt = $list[$i]['idteam'];
		$nt = $list[$i]['TN'];
		echo "add($idl,'$nl',$s,$idd,'$nd',$idt,'$nt');\n";
	}
}
?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'players-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
	  'afterValidate' => 'js: function(form, data, hasError) {
		  if (!hasError){
			  if ('.$model->isNewRecord.'+0){
				  alert("Player "+$("input#Players_Firstname").val()+" "+$("input#Players_Lastname").val()+" successfully added.");
			  }else{
				  alert("Player "+$("input#Players_Firstname").val()+" "+$("input#Players_Lastname").val()+" successfully updated.");
			  }
			  return true;
		  }
	  }'
	  )
)); ?>

<div class="clear"></div>

<?php echo $form->errorSummary($model); ?>

<div style='text-align: center'>

<div class="blacktitle"> PLAYER INFO</div>
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
            <select style="width:216px !important; text-align:center" id="Teams_Division_iddivision"></select>
            </div>
    </div>
	
	<div class="rowdiv">
        <div class="green"> Team<span class="required">*</span></div>
        <div class="gray">

            <?
            // $team_selected = Yii::app()->session['team'];

            // if (Yii::app()->session['role'] == 'admins') {
                // $teams = Teams::model()->findAll(array('order'=>'Name ASC'));
            // } else if (Yii::app()->session['role'] == 'roster') {
                // $teams = Teams::model()->findAll(array("condition" => "idteam = $team_selected",'order'=>'Name ASC'));
            // }
            // $listTeams = CHtml::listData($teams, 'idteam', 'Name');
            ?>
            <?php //echo $form->dropDownList($model,'Teams_idteam',$listTeams,array('options' => array($team_selected =>array('selected'=>true)))); ?>
            <?php echo $form->dropDownList($model, 'Teams_idteam', array(),array_merge($disabledArray,array("empty"=>"Select a Team","style"=>"width:216px !important;"))); ?>
            <?php echo $form->error($model, 'Teams_idteam'); ?>
			
			<input type="hidden" name="Players[Teams_idteam]" id="Players_Teams_idteam_second" value="-1"/>
        </div>
    </div>
	
    <div class="rowdiv">
        <div class="green">First Name<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'Firstname', array_merge($disabledArray,array('size' => 50, 'maxlength' => 50))); ?>
            <?php echo $form->error($model, 'Firstname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Last Name<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'Lastname', array_merge($disabledArray,array('size' => 50, 'maxlength' => 50))); ?>
            <?php echo $form->error($model, 'Lastname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Number<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'Number', $disabledArray); ?>
            <?php echo $form->error($model, 'Number'); ?>
        </div>
    </div>

    <?
    $positions = array('P' => 'P', 'C' => 'C', '1B' => '1B', '2B' => '2B', '3B' => '3B', 'SS' => 'SS',
        'LF' => 'LF', 'CF' => 'CF', 'RF' => 'RF', 'EF' => 'EF', 'DH' => 'DH', 'PH' => 'PH',
        'PR' => 'PR', 'CR' => 'CR', 'EH' => 'EH', 'X' => 'X', 'SF' => 'staff');
    ?>

    <div class="rowdiv">
        <div class="green"> Position<span class="required">*</span></div>
        <div class="gray">

            <?php //echo $form->textField($model,'Position',array('size'=>2,'maxlength'=>2)); ?>
            <?php echo $form->dropDownList($model, 'Position',
                $positions, array_merge($disabledArray,array('class' => 'selectpositions', 'style' => 'width:216px !important; text-align:center', 'options' => array($model->Position => array('selected' => true))))
            );?>
            <?php echo $form->error($model, 'Position'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Bats<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Bats', array('R' => 'Right', 'S' => 'Switch', 'L' => 'Left'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'Bats'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Throws<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Throws', array('R' => 'Right', 'L' => 'Left'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'Throws'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Height<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'foot', array("4"=>"4","5"=>"5","6"=>"6","7"=>"7",), array_merge($disabledArray,array('style' => 'width:65px !important; text-align:center')));?>
             feet
            <?php echo $form->dropDownList($model, 'inches', array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11"), array_merge($disabledArray,array('style' => 'width:65px !important; text-align:center')));?>
            inches
            <?php //echo $form->textField($model, 'Height'); ?>
            <?php echo $form->error($model, 'Height'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Weight<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'Weight',$disabledArray); ?>
            <?php echo $form->error($model, 'Weight'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Birth Date</div>
        <div class="gray">
            <?php
			if ($disabled){
				echo $form->textField($model, 'Birthdate',$disabledArray);
			} else{
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'     => $model,
					'attribute' => 'Birthdate',
					'htmlOptions' => array(
						'size' => '10', // textField size
						'maxlength' => '10', // textField maxlength
						'value' => substr($model->Birthdate, 0, 10),
						'style' => 'width:180px',
					),
					'options' => array(
						'showOn' => 'both', // also opens with a button
						'dateFormat' => 'yy-mm-dd', // format of "2012-12-25"
						'defaultDate'=>"1996-01-01",
						'changeMonth'=> true,
						'changeYear'=> true
					)                
				));
			}
            ?>
            <?php echo $form->error($model, 'Birthdate'); ?>
        </div>
    </div>

    <?php  $states = array(""=>"","AL"=>"AL","AK"=>"AK","AZ"=>"AZ","AR"=>"AR","CA"=>"CA","CO"=>"CO",
                "CT"=>"CT","DE"=>"DE","FL"=>"FL","GA"=>"GA","HI"=>"HI","ID"=>"ID","IL"=>"IL",
                "IN"=>"IN","IA"=>"IA","KS"=>"KS","KY"=>"KY","LA"=>"LA","ME"=>"ME","MD"=>"MD",
                "MA"=>"MA","MI"=>"MI","MN"=>"MN","MS"=>"MS","MO"=>"MO","MT"=>"MT","NE"=>"NE",
                "NV"=>"NV","NH"=>"NH","NJ"=>"NJ","NM"=>"NM","NY"=>"NY","NC"=>"NC","ND"=>"ND",
                "OH"=>"OH","OK"=>"OK","OR"=>"OR","PA"=>"PA","RI"=>"RI","SC"=>"SC","SD"=>"SD",
                "TN"=>"TN","TX"=>"TX","UT"=>"UT","VT"=>"VT","VA"=>"VA","WA"=>"WA","WV"=>"WV",
                "WI"=>"WI","WY"=>"WY"); ?>

    <div class="rowdiv">
        <div class="green"> Home Town</div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'State', $states, array_merge($disabledArray,array('style' => 'width:62px !important; text-align:center')));?>
            <?php echo $form->textField($model, 'Hometown', array_merge($disabledArray,array('style' => 'width:140px !important;')));?>
            <?php echo $form->error($model, 'Hometown'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> College<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'College',$disabledArray); ?>
            <?php echo $form->error($model, 'College'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Class</div>
        <div class="gray">
            <?php
                $first = date("Y")*1-5;
                $years = array($first=>$first);
                for($i = 1; $i < 16 ; $i++){
                    $years[$first+$i] = $years[$first]+$i;
                }
            ?>
            <?php 
                $model->Class = $model->Class ? $model->Class : date("Y");
                echo $form->dropDownList($model, 'Class', $years, array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php //echo $form->textField($model, 'Class', $disabledArray); ?>
            <?php echo $form->error($model, 'Class'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green" style='height: 75px'> Biography</div>
        <div class="gray" style='height: 75px'>
            <?php echo $form->textarea($model, 'Biography', $disabledArray); ?>
            <?php echo $form->error($model, 'Biography'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Status<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green" style='height: <?php echo $disabled ? '30px': '60px'; ?>'><?php echo $disabled ? '': 'Photo'; ?></div>
        <div class="gray" style='height: <?php echo $disabled ? '30px': '60px'; ?>'>
            <?php
			if (!$disabled){
				echo $form->fileField($model, 'uploadfile', array('class' => 'filebutton'));
				echo $form->error($model, 'uploadfile');
				echo $form->hiddenField($model,'Photo');
				echo $form->hiddenField($model,'thumb');
			}
            ?>
        </div>
    </div>


    <div class="row buttons">
		<?php 
			if ($disabled){
				echo CHtml::link('Cancel',
					array(
						'players/admin',
						'Players_page'=>isset(Yii::app()->session['Players_page']) ? Yii::app()->session['Players_page'] : 1),
					array('class'=>'save-form-btn'));
			} else {
				echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array("class"=>"save-form-btn"));
				echo CHtml::submitButton(($model->isNewRecord ? 'Add' : 'Update').'/Next',array("class"=>"save-form-btn",'name'=>'next'));
				echo CHtml::link('Close',
					array(
						'players/admin',
						'Players_page'=>isset(Yii::app()->session['Players_page']) ? Yii::app()->session['Players_page'] : 1),
					array('class'=>'save-form-btn'));
			}
		?>
    </div>

    <div class='playerphoto' >
        <? if ($model->Photo) { ?>
            <?php $this->beginWidget('application.extensions.thumbnailer.Thumbnailer', array(
                    'thumbsDir' => 'images/thumbs',
                    'thumbWidth' => 125,
                    //'thumbHeight' => 150, // Optional
                )
            ); ?>
            <img src="images/players/<?php echo $model->thumb ?>"/>
            <?php $this->endWidget(); ?>
        <?
        }
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div><!-- form -->

<script>
(function(){
	var $leagueSelect = $("#Teams_League_idleague");
	var $seasonSelect = $("#Teams_Season");
	var $divisionSelect = $("#Teams_Division_iddivision");
	var $teamSelect = $("#Players_Teams_idteam");
	var counter = 0;
	
	var data = {};
	function add(idleague, leagueName, season, iddivision, divisionName, idteam, teamName){
		if (!data[idleague])
			data[idleague] = {
				id: idleague,
				name: leagueName,
				seasons: []
			};
		if (!data[idleague].seasons[season])
			data[idleague].seasons[season] = {
				id: season,
				name: season,
				divisions: []
			};
		if (!data[idleague].seasons[season].divisions[iddivision])
			data[idleague].seasons[season].divisions[iddivision] = {
				id: iddivision,
				name: divisionName,
				teams: []
			};
			
		data[idleague].seasons[season].divisions[iddivision].teams[idteam] = {
			id: idteam,
			name: teamName
		};
	}
	
	function updateSelect($obj, data, defaultId){
		$obj.children().remove();
		counter = 0;
		for(var i in data){
			var $opt = $("<option>")
				.val(data[i].id)
				.text(data[i].name).appendTo($obj);
			if (data[i].id == defaultDision)
				$opt.prop("selected",1);
			counter++;
		}
		$obj.prop("disabled",counter == 1 || isUiDisabled);
		$obj.change();
	}
	
	<?php
	createLeagueSeasonDivisionTeamDependency();
	echo 'var isUiDisabled='.($disabled? 'true': 'false').';';
	
	if ($model->isNewRecord){
		echo 'var defaultLeague='.Settings::get()->idleague.";\n";
		echo 'var defaultSeason='.Settings::get()->season.";\n";
		echo "var defaultDision=data[defaultLeague].seasons[defaultSeason].divisions.find(function(q){return q;}).id;\n";
		echo "var defaultTeam=data[defaultLeague].seasons[defaultSeason].divisions[defaultDision].teams.find(function(q){return q;}).id;\n";
	} else {
		echo 'var defaultLeague='.$model->teamsIdteam->divisionIddivision->league_idleague.";\n";
		echo 'var defaultSeason='.Division::model()->getSeason($model->teamsIdteam->divisionIddivision).";\n";
		echo "var defaultDision=".$model->teamsIdteam->divisionIddivision->iddivision.";\n";
		echo "var defaultTeam=".$model->teamsIdteam->idteam.";\n";
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
	var selectedSeason = 0;
	$leagueSelect.change(function(){
		var id = $("option:selected", this).val();
		selectedLeague = id;
		updateSelect($seasonSelect, data[id].seasons, defaultSeason);
	});
	
	$seasonSelect.change(function(){
		var id = $("option:selected", this).val();
		selectedSeason = id;
		updateSelect($divisionSelect, data[selectedLeague].seasons[id].divisions, defaultDision);
	});
	
	$divisionSelect.change(function(){
		var id = $("option:selected", this).val();
		updateSelect($teamSelect, data[selectedLeague].seasons[selectedSeason].divisions[id].teams, defaultTeam);
	});
	
	$teamSelect.change(function(){
		var id = $("option:selected", this).val();
		$("#Players_Teams_idteam_second").val(id);
	})
	
	$leagueSelect.change();
})();
</script>