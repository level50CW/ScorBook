<?php
$disabledArray = array();
$disabledConfirm = false;
if( isset($disabled) && $disabled ){
    $disabledArray= array(
        "disabled"=>"disabled",
        "readonly"=>"readonly",
    );
	$disabledConfirm = true;
} else {
	$disabled = false;
}


function createLeagueDivisionTeamDependency()
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
        <div class="green">Role<span class="required">*</span></div>
        <div class="gray">
        <?php echo $form->dropDownList($model, 'role',
			(Yii::app()->session['role'] == 'admins' || Yii::app()->session['role'] == 'leagueadmin')?
				array(
					'admins' => 'System Admin',
					'leagueadmin' => 'League Admin',
					'teamadmin' => 'Team Admin',
					'roster' => 'Team Roster Admin',
					'scorer' => 'Scorekeeper',
					'user' => 'User',):
				array('user' => 'User'),
			array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center'))); ?>
        </div>
    </div>

	<div class="rowdiv">
        <div class="green" > League <span class="required">*</span></div>
            <div class="gray">
			<select style="width:216px !important; text-align:center" id="Teams_League_idleague"></select>
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
			
			<input type="hidden" name="Users[Teams_idteam]" id="Users_Teams_idteam_second"/>
        </div>
    </div>

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
        <div class="green">Security code</div>
        <div class="gray">
        <?php echo $form->textField($model,'code',array_merge($disabledArray,array('size'=>60,'maxlength'=>150))); ?>
        <?php echo $form->error($model,'code'); ?>
        </div>
    </div>
	
<br/>

<div class="rowdiv">
    <?php if( isset($disabled) && $disabled ){
        echo CHtml::link('Close',array('users/admin', 'Users_page'=>isset(Yii::app()->session['Users_page']) ? Yii::app()->session['Users_page'] : 1),array('class'=>'save-form-btn'));
    }
    else{
		$onClick = '
		if ($("#Users_Password").val()=="'.$model->Password.'") return true;
		
		if ($("#Users_Password").val()!=$("#Users_Confirm").val()){
			alert("The passwords you entered do not match");
			return false;
		}
		if ($("#Users_Password").val().match(/^(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9_$%-]{8,16}$/) == null){
			alert("You have entered an invalid password. Passwords must have between 8 and 16 characters with at least 1 uppercase and 1 lowercase letter. The only special characters allowed are $, %, - and _.");
			return false;
		}
		return true;
		';
        echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array("class"=>"save-form-btn" , 'style'=>'margin: -10px 10px 0 0;', "onclick"=>$onClick));
		echo CHtml::submitButton(($model->isNewRecord ? 'Add' : 'Update').'/Next',array("class"=>"save-form-btn", 'style'=>'margin: -10px 10px 0 0;', 'onclick'=>$onClick, 'name'=>'next'));
        echo CHtml::link('Cancel',array('users/admin', 'Users_page'=>isset(Yii::app()->session['Users_page']) ? Yii::app()->session['Users_page'] : 1),array('class'=>'save-form-btn'));
    } ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script>
(function(){
	var $roleSelect = $("#Users_role");
	var $leagueSelect = $("#Teams_League_idleague");
	//var $seasonSelect = $("#Teams_Season");
	var $divisionSelect = $("#Teams_Division_iddivision");
	var $teamSelect = $("#Users_Teams_idteam");
	
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
	
	function disableSelectes()
	{
		$divisionSelect.children().remove();
		$teamSelect.children().remove();
		
		$divisionSelect.append($("<option>").val("").text("NA")).prop("disabled",true);
		$teamSelect.append($("<option>").val("").text("NA")).prop("disabled",true);
		$("#Users_Teams_idteam_second").val(-1);
	}
		
	<?php
	createLeagueDivisionTeamDependency();
	echo 'var isUiDisabled='.($disabled? 'true': 'false').';';
	
	if ($model->isNewRecord || !$model->teamsIdteam){
		echo 'var defaultLeague='.Settings::get()->idleague.';';
		echo 'var defaultDision="";';
		echo 'var defaultTeam="";';
	} else {
		echo 'var defaultLeague='.$model->teamsIdteam->divisionIddivision->league_idleague.";\n";
		echo "var defaultDision=".$model->teamsIdteam->divisionIddivision->iddivision.";\n";
		echo "var defaultTeam=".$model->teamsIdteam->idteam.";\n";
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
		$("#Users_Teams_idteam_second").val(id);
	});
	
	$roleSelect.change(function(){
		var role = $roleSelect.val();
		if (role == "admins" || 
			role == "leagueadmin"){
			disableSelectes();
		} else {
			createSelectes();
			$leagueSelect.change();
		}
	})
	
	$roleSelect.change();
	$roleSelect.prop("disabled",$roleSelect.children().length == 1 || isUiDisabled);
	
	var defaultLeague=<?php echo Settings::get()->idleague;?>;
	var defaultDision="";
	var defaultTeam="";
})();
</script>