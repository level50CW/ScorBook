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
} else {
	$disabled = false;
}

function createLeagueSeasonDivisionTeamDependency()
{
	if (Yii::app()->session['role'] == 'admins' || Yii::app()->session['role'] == 'leagueadmin') {
		$list= Yii::app()->db->createCommand('SELECT DISTINCT l.`idleague`, l.`Name` AS `LN`, d.`iddivision`, d.`Name` AS `DN`, t.`idteam`, t.`Name` AS TN
												FROM `teams` t
												RIGHT JOIN `division` d ON d.`iddivision`=t.`Division_iddivision`
												RIGHT JOIN `league` l ON l.`idleague`=d.`league_idleague`')->queryAll();
	}else if (Yii::app()->session['role'] == 'roster' || Yii::app()->session['role'] == 'teamadmin') {
		$team_selected = Yii::app()->session['team'];
		$list= Yii::app()->db->createCommand('SELECT DISTINCT l.`idleague`, l.`Name` AS `LN`, d.`iddivision`, d.`Name` AS `DN`, t.`idteam`, t.`Name` AS TN
												FROM `teams` t
												RIGHT JOIN `division` d ON d.`iddivision`=t.`Division_iddivision`
												RIGHT JOIN `league` l ON l.`idleague`=d.`league_idleague`
												WHERE t.`idteam`=:userTeamId')->queryAll(true,array(':userTeamId'=>$team_selected));
	}
											
	for($i=0; $i<count($list); $i++){
		$idl = $list[$i]['idleague'];
		$nl = $list[$i]['LN'];
		$idd = $list[$i]['iddivision']? $list[$i]['iddivision']: 'null';
		$nd = $list[$i]['DN']? $list[$i]['DN']: 'null';
		$idt = $list[$i]['idteam']? $list[$i]['idteam']: 'null';
		$nt = $list[$i]['TN']? $list[$i]['TN']: 'null';
		echo "add($idl,'$nl',$idd,'$nd',$idt,'$nt');\n";
	}
}
?>

<style>
.ui-datepicker-month,
.ui-datepicker-year{
	color: grey;
}
</style>

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
			<?php			
				$seasons = CHtml::listData(Season::model()->findAll(), 'idseason', 'season');
				
				?>
			<?php echo $form->dropDownList($model,'season_idseason',$seasons,array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center',
						'options'=>$model->isNewRecord?
							array(Settings::get()->idseason => array('selected'=>true)) : 
							array())));?>
            <?php echo $form->error($model,'season_idseason'); ?>
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

            <?php 
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
			
			<input type="hidden" name="Players[Teams_idteam]" id="Players_Teams_idteam_second" value=""/>
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

    <?php 
    $positions = array('P' => 'P', 'C' => 'C', '1B' => '1B', '2B' => '2B', '3B' => '3B', 'SS' => 'SS',
        'LF' => 'LF', 'CF' => 'CF', 'RF' => 'RF', 'EF' => 'EF', 'DH' => 'DH', 'PH' => 'PH',
        'PR' => 'PR', 'CR' => 'CR', 'MG' => 'Manager', 'AC' => 'Asst. Coach', 'BC' => 'Batting Coach', 'PC' => 'Pitching Coach');
    ?>

    <div class="rowdiv">
        <div class="green"> Position<span class="required">*</span></div>
        <div class="gray">

            <?php //echo $form->textField($model,'Position',array('size'=>2,'maxlength'=>2)); ?>
            <?php echo $form->dropDownList($model, 'Position',
                $positions, array_merge($disabledArray,array('class' => 'selectpositions', 
				'style' => 'width:216px !important; text-align:center', 
				'empty'=>'Select Position')));?>
            <?php echo $form->error($model, 'Position'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Bats<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Bats', array('R' => 'Right', 'S' => 'Switch', 'L' => 'Left'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'Bats'); ?>
			<input type="hidden" name="Players[Bats]" id="Players_Bats_h" disabled="disabled" value="NA"/>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Throws<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Throws', array('R' => 'Right', 'L' => 'Left'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'Throws'); ?>
			<input type="hidden" name="Players[Throws]" id="Players_Throws_h" disabled="disabled" value="NA"/>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Height<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'foot', 
				array("4"=>"4","5"=>"5","6"=>"6","7"=>"7",), 
				array_merge($disabledArray,
					array(
						'style' => 'width:65px !important; text-align:center', 
						'options'=>$model->isNewRecord? array('5'=>array('selected'=>true)): array())));?>
             feet
            <?php echo $form->dropDownList($model, 'inches', 
				array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11"), 
				array_merge($disabledArray,
					array(
						'style' => 'width:65px !important; text-align:center', 
						'options'=>$model->isNewRecord? array('7'=>array('selected'=>true)): array())));?>
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
						'size' => '5', // textField size
						'maxlength' => '5', // textField maxlength
						'value' => substr($model->Birthdate, 0, 10),
						'style' => 'width:180px',
					),
					'options' => array(
						'showOn' => 'both', // also opens with a button
						'dateFormat' => 'yy-mm-dd', // format of "2012-12-25"
						'defaultDate'=>"1993-01-01",
						'minDate'=>(+date('Y')-29)."-01-01",
						'maxDate'=>(+date('Y')-16)."-01-01",
						'changeMonth'=> true,
						'changeYear'=> true
					)                
				));
			}
            ?>
            <?php echo $form->error($model, 'Birthdate'); ?>
        </div>
    </div>

    <?php  $states = array("AL"=>"AL","AK"=>"AK","AZ"=>"AZ","AR"=>"AR","CA"=>"CA","CO"=>"CO",
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
            <?php echo $form->dropDownList($model, 'State', $states, array_merge($disabledArray,array(
				'style' => 'width:62px !important; text-align:center',
				'empty'=> 'State')));?>
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
                echo $form->dropDownList($model, 'Class', 
					array(0=>'Freshman', 1=>'Sophomore', 2=>'Junior', 3=>'Senior', 4=>'Grad School'), 
					array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
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
        <?php if ($model->Photo) { ?>
            <?php $this->beginWidget('application.extensions.thumbnailer.Thumbnailer', array(
                    'thumbsDir' => 'images/thumbs',
                    'thumbWidth' => 125,
                    //'thumbHeight' => 150, // Optional
                )
            ); ?>
            <img src="images/players/<?php echo $model->thumb ?>"/>
            <?php $this->endWidget(); ?>
        <?php 
        }
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div><!-- form -->

<script>
(function(){
	var $leagueSelect = $("#Teams_League_idleague");
	var $divisionSelect = $("#Teams_Division_iddivision");
	var $teamSelect = $("#Players_Teams_idteam");
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
		
		if (!data[idleague].divisions[iddivision]){
			data[idleague].divisions[iddivision] = {
				id: iddivision,
				name: divisionName,
				teams: []
			};
			data[idleague].divisions[iddivision].teams[""] = {
				id: "",
				name: "Select Team"
			};
		}
		
		if (idteam == null)
			return;
		
		data[idleague].divisions[iddivision].teams[idteam] = {
			id: idteam,
			name: teamName
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
		$teamSelect.children().remove();
		
		$leagueSelect.prop("disabled",isUiDisabled);
		$divisionSelect.prop("disabled",isUiDisabled);
		$teamSelect.prop("disabled",isUiDisabled);
		
		
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
	createLeagueSeasonDivisionTeamDependency();
	echo 'var isUiDisabled='.($disabled? 'true': 'false').';';
	echo 'var defaultSeason='.Settings::get()->idseason.";\n";
	
	if ($model->isNewRecord){
		echo 'var defaultLeague='.Settings::get()->idleague.";\n";
		echo 'var defaultDision="";'."\n";
		echo 'var defaultTeam="";'."\n";
	} else {
		echo 'var defaultLeague='.($model->teamsIdteam->divisionIddivision->league_idleague? $model->teamsIdteam->divisionIddivision->league_idleague : '""').";\n";
		echo "var defaultDision=".($model->teamsIdteam->divisionIddivision->iddivision? $model->teamsIdteam->divisionIddivision->iddivision: '""').";\n";
		echo "var defaultTeam=".($model->teamsIdteam->idteam? $model->teamsIdteam->idteam : '""').";\n";
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
		
		$teamSelect.children().remove();
		if (id)
			updateSelect($teamSelect, data[selectedLeague].divisions[id].teams, defaultTeam);
		$teamSelect.prop(isUiDisabled);
		$teamSelect.change();
	});
	
	$teamSelect.change(function(){
		var id = $("option:selected", this).val();
		$("#Players_Teams_idteam_second").val(id || "");
	});
	
	$("#Players_Position").change(function(){
		if ($(this).val() == 'MG' ||
				$(this).val() == 'AC' ||
				$(this).val() == 'BC' ||
				$(this).val() == 'PC'){
			$("#Players_Bats").append($("<option>").val("NA").text("NA")).val("NA").prop("disabled",true);
			$("#Players_Throws").append($("<option>").val("NA").text("NA")).val("NA").prop("disabled",true);
			$("#Players_Bats_h").prop("disabled",false);
			$("#Players_Throws_h").prop("disabled",false);
		} else {
			$("option[value=NA]","#Players_Bats").remove();
			$("option[value=NA]","#Players_Throws").remove();
			$("#Players_Bats").prop("disabled",false).change();
			$("#Players_Throws").prop("disabled",false).change();
			$("#Players_Bats_h").prop("disabled",true);
			$("#Players_Throws_h").prop("disabled",true);
		}
	});
	
	$("#Players_Position").change();	
	$leagueSelect.change();
	
	var defaultLeague=<?php echo Settings::get()->idleague;?>;
	var defaultDision="";
	var defaultTeam="";
})();
</script>