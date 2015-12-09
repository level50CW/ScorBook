<?php
/* @var $this GamesController */
/* @var $model Games */
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

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'games-form',
    'enableAjaxValidation'=>true,
	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
	  'afterValidate' => 'js: function(form, data, hasError) {
		  if (!hasError){
			  if ('.$model->isNewRecord.'+0){
				  alert("Game on "+$(\'input[name="Games[date]"]\').val().split(" ")[0]+" at "+$(\'input[name="Games[date]"]\').val().split(" ")[1]+ " between "+$(\'select[name="Games[Teams_idteam_home]"] option:selected\').text()+" and "+$(\'select[name="Games[Teams_idteam_visiting]"] option:selected\').text()+" was successfully added to the Schedule.");
			  }else{
				  alert("Game on "+$(\'input[name="Games[date]"]\').val().split(" ")[0]+" at "+$(\'input[name="Games[date]"]\').val().split(" ")[1]+ " between "+$(\'select[name="Games[Teams_idteam_home]"] option:selected\').text()+" and "+$(\'select[name="Games[Teams_idteam_visiting]"] option:selected\').text()+" was successfully updated.");
			  }
			  return true;
		  }
	  }'
	  )
)); ?>

<div class="row">
    <?php echo $form->hiddenField($model, 'idgame'); ?>
    <?php echo $form->error($model, 'idgame'); ?>
</div>

<?
//Seleccionamos la liga del equipo que tiene el usuario si no es admin

$team_selected = Yii::app()->session['team'];
if ($model->isNewRecord)
	$modelLeague = League::model()->findByPk(Settings::get()->idleague);
else
	$modelLeague = League::model()->findByPk($model->divisionIddivisionHome->league_idleague);
	

if (Yii::app()->session['role'] == 'admins' || Yii::app()->session['role'] == 'leagueadmin') {

    $divisions = Division::model()->findAllByAttributes(array('league_idleague'=>$modelLeague->idleague));
    $divisionsListHome = CHtml::ListData($divisions, 'iddivision', 'Name');

    $divisions = Division::model()->findAllByAttributes(array('league_idleague'=>$modelLeague->idleague));
    $divisionsList = CHtml::ListData($divisions, 'iddivision', 'Name');
	
	$teams = Teams::model()->findAll(array('order' => 'Name'));
    $teamsListHome = CHtml::ListData($teams, 'idteam', 'Name');

    $teams = Teams::model()->findAll(array('order' => 'Name'));
    $teamsList = CHtml::ListData($teams, 'idteam', 'Name');

}else if (Yii::app()->session['role'] == 'roster' || Yii::app()->session['role'] == 'teamadmin') {

    $divisions = Division::model()->findAllBySql("SELECT l.iddivision,l.Name FROM Division as l INNER JOIN Teams t ON(l.iddivision = t.Division_iddivision) WHERE idteam=:a AND l.league_idleague=:lid",array(':a' => $team_selected,':lid'=>$modelLeague->idleague));
    $divisionsListHome = CHtml::ListData($divisions, 'iddivision', 'Name');

    $divisions = Division::model()->findAllByAttributes(array('league_idleague'=>$modelLeague->idleague));
    $divisionsList = CHtml::ListData($divisions, 'iddivision', 'Name');
	
	$teams = Teams::model()->findAll(array("condition" => "idteam =  $team_selected", 'order' => 'Name'));
    $teamsListHome = CHtml::ListData($teams, 'idteam', 'Name');

    $teams = Teams::model()->findAll(array('order' => 'Name'));
    $teamsList = CHtml::ListData($teams, 'idteam', 'Name');

}

function createSeasonPeriods($model){
	$seasons = Season::model()->findAll();
	
	$res = '{';
	for($i=0;$i<count($seasons);$i++){
		$currentSeason = $seasons[$i];
		$id = $currentSeason->idseason;
		$dateStart = $currentSeason->startdate.' 00:00';
		$dateEnd = $currentSeason->enddate.' 00:00';
		$dateUSStart = $model->dateToAmericanFormat($dateStart);
		$dateUSEnd = $model->dateToAmericanFormat($dateEnd);
		$season = $currentSeason->season;
		$res.="'$id':{'season':'$season','start':'$dateStart', 'end':'$dateEnd','startUs':'$dateUSStart', 'endUs':'$dateUSEnd'},";
	}
	$res.='};';
	echo $res;
}


?>


<?php echo $form->errorSummary($model); ?>

<br/>
<div class="blacktitle"> GAME INFO</div>
<div class="rowdiv">
	<div class="green"> League <span class="required">*</span></div>
	<div class="gray">
		<?php echo $form->textField($modelLeague, 'Name', array('size' => 60, 'maxlength' => 200,"disabled"=>"disabled","readonly"=>"readonly",)); ?>
	</div>
</div>


<div class="rowdiv">
    <div class="brown"> Season <span class="required">*</span></div>
    <div class="gray">
		<?php
			// $dateNow = date_create('now');
			// $dateEndOfSeason = date_create(date('Y').'-09-30');
			// $lowestSeason = $model->isNewRecord? 
				// min(Settings::get()->season,($dateNow > $dateEndOfSeason? 1+date('Y'): +date('Y'))): 
				// min(+$model->season, +date('Y'));
		
			$seasons = CHtml::listData(Season::model()->findAll(), 'idseason', 'season');
			
			if ($model->isNewRecord){
				echo $form->dropDownList($model, 'season_idseason', $seasons, array(
					"style"=>"width:216px !important;",
					'options'=>array(Settings::get()->idseason => array('selected'=>true))));
			} else {
				echo $form->dropDownList($model, 'season_idseason', $seasons, array(
					"style"=>"width:216px !important;",
					'disabled' => true,
					'options'=>array(''+$model->season_idseason => array('selected'=>true))));
			}
		?>

        <?php echo $form->error($model, 'season_idseason'); ?>
    </div>
</div>

<div class="rowdiv">

    <div class="green"> Date <span class="required">*</span></div>
    <div class="gray">


        <?php
        if( isset($disabled) && $disabled ){
            echo $form->textField($model, 'date', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200)));
        }
        else{
            $this->widget('application.extensions.timepicker.timepicker', array(
                'model' => $model,
                'name' => 'date', 
                'options' => array(
                    'showOn'=>'focus',
                    'timeFormat'=>'hh:mm',
                    'dateFormat' => 'mm-dd-yy',
                ),
            ));
        }
        ?>

        <?php echo $form->error($model, 'date'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="brown">Type</div>
    <div class="gray">
        <?php echo $form->dropDownList($model, 'game_type', array('0' => 'Regular','1' => 'Playoff', '2' => 'Championship'),array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
        <?php echo $form->error($model, 'game_type'); ?>
    </div>
</div>


<div class="rowdiv">
    <div class="green"> Status <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->dropDownList($model, 'status',
			$model->isNewRecord? array('0' => 'Scheduled – Active','-1' => 'Scheduled – Inactive',) : array(
            '0' => 'Scheduled – Active','-1' => 'Scheduled – Inactive', '1' => 'in progress', '2' => 'End-regulation', '3' => 'End-extraInnings', '4' => 'End-timeLimit', '5' => 'End-runRule', '6' => 'End-forfeit', '7' => 'End-darkness',
            '8' => 'End-rainOut', '9' => 'End-other', '10' => 'Suspended - Darkness', '11' => 'Suspended-rain', '12' => 'Suspended-other'),
			array_merge($disabledArray,
			array(
				'style' => 'width:216px !important; text-align:center', 
				'options'=> $model->isNewRecord? array('-1'=>array('selected'=>true)): array())));?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>



<div class="clear"></div>

<div class="blacktitle"> HOME TEAM</div>
<div class="rowdiv">
    <div class="green"> Division <span class="required">*</span></div>
    <div class="gray">
        <?
        echo $form->dropDownList($model, 'Division_iddivision_home', $divisionsListHome,
            array_merge($disabledArray,
            array(
                'empty' => 'Select Division',
                'style' => 'width:216px !important; text-align:center',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsHome'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_home', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                ))));
        ?>
        <?php echo $form->error($model, 'Division_iddivision_home'); ?>
    </div>
</div>


<div class="rowdiv">
    <div class="brown"> Team <span class="required">*</span></div>
    <div class="gray">
        <?php //echo $form->textField($model,'Teams_idteam_home'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_home', $model->Teams_idteam_home ? $teamsListHome : array(), array_merge($disabledArray,array('empty' => 'Select Team', 'style' => 'width:216px !important; text-align:center',))); ?>
        <?php echo $form->error($model, 'Teams_idteam_home'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green"> Stadium <span class="required">*</span></div>
    <div class="gray">
        <?php
            $tmpLocList = CHtml::listData(Teams::model()->findAll(),'location','idteam');
            $locSTR = $model->location;
            if (!empty($locSTR)) {
                $model->location = $tmpLocList[$model->location];
            }
        ?>
        <?php echo $form->dropDownList($model, 'location', CHtml::listData(Teams::model()->findAll(), 'idteam', 'location'), array('empty' => '', 'style' => 'width:216px !important; text-align:center; display:none;','readonly'=>'readonly')); ?>
        <?php echo CHtml::textField('locationTF', $locSTR ,array('readonly'=>'readonly')); ?>
        <?php echo $form->error($model, 'location'); ?>
    </div>
</div>
<div class="clear">

</div>

<div class="blacktitle"> VISITING TEAM</div>
<div class="rowdiv">
    <div class="green"> Division <span class="required">*</span></div>
    <div class="gray">
        <?
        echo $form->dropDownList($model, 'Division_iddivision_visiting', $divisionsList,
            array_merge($disabledArray,
            array(
                'empty' => 'Select Division',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsVisiting'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_visiting', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                    
                ))));
        ?>
        <?php echo $form->error($model, 'Division_iddivision_visiting'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="brown"> Team <span class="required">*</span></div>
    <div class="gray">
        <? echo Yii::trace(CVarDumper::dumpAsString($model->Teams_idteam_visiting), 'varVisi'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_visiting', $model->Teams_idteam_visiting ? $teamsList : array(), array_merge($disabledArray,array('empty' => 'Select Team'))); ?>
		<?php echo $form->error($model, 'Teams_idteam_visiting'); ?>
	</div>
</div>


<? //USERS ID SCOREKEEPER
echo $form->hiddenField($model, 'Users_iduser', array('value' => Yii::app()->user->id));
?>

<?
echo CHtml::hiddenField('link', '', array('id' => 'link'));;
?>

<br>
<?php if( !isset($disabled) ){ ?>
    <div class="rowdiv">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('class'=>'save-form-btn','style'=>'margin-top: 0;')); ?>
        <?php echo CHtml::submitButton(($model->isNewRecord ? 'Add' : 'Update').'/Next',array("class"=>"save-form-btn", 'style'=>'margin-top: 0;', 'name'=>'next')); ?>
        <?php echo CHtml::link('Cancel',array('schedule/admin', 'Schedule_page'=>isset(Yii::app()->session['Schedule_page']) ? Yii::app()->session['Schedule_page'] : 1), array('class'=>'save-form-btn'));?>
    </div>
<?php } 
else { ?>
    <div class="rowdiv">
        <?php echo CHtml::link('Close',array('schedule/admin', 'Schedule_page'=>isset(Yii::app()->session['Schedule_page']) ? Yii::app()->session['Schedule_page'] : 1), array('class'=>'save-form-btn'));?>
    </div>
<?php } ?>

<?php $this->endWidget(); ?>

</div><!-- form -->




<?php
Yii::app()->clientScript->registerScript('update', "

$('select[name=\"Games[Teams_idteam_home]\"]').on('change',function(){
    $('select[name=\"Games[location]\"]').val($(this).val());
    $('#locationTF').val($('select[name=\"Games[location]\"]').find(\"option[value=\"+$(this).val()+\"]\").text());
});

var myVar = setInterval(function(){ 
    $('select[name=\"Games[Teams_idteam_home]\"]').change();
}, 300);

"); ?>

<script>
	(function(){
		var timer = 0;
		var seasons = <?php echo createSeasonPeriods($model);?>;
		
		function defaultDate(){
			return seasons[+$("#Games_season_idseason").val()].startUs;
		}
		
		function updateRange(){
			jQuery('#yw0').datetimepicker('option','minDate', new Date(seasons[+$("#Games_season_idseason").val()].start));
			jQuery('#yw0').datetimepicker('option','maxDate', new Date(seasons[+$("#Games_season_idseason").val()].end));
		}
		
		// $(".timepicker").change(function(){
			// if (!timer){
				// var $self = $(this);
				// timer = setTimeout(function(){
					// var date = new Date($self.val());
					
					// if (+$("#Games_season_idseason").val() != date.getFullYear() || date < new Date(date.getFullYear(),4,1) || date > new Date(date.getFullYear(),8,30)){
						// alert("Season of the selected date does not coincide with the current season.");
						// $self.val(defaultDate());
					// } else {
						// var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
						// $("#header-date").text(monthNames[date.getMonth()]+" "+date.getDate());
					// }
					
					// timer = 0;
				// },10);
			// }
		// });
		
		$("#Games_Teams_idteam_home").change(function(){
			var text = $("option:selected", this).text();
			$("#header-teamNameHome").text(text);
		});
		
		$("#Games_Teams_idteam_visiting").change(function(){
			var text = $("option:selected", this).text();
			$("#header-teamNameVisiting").text(text);
		});
		
		$("#Games_season_idseason").change(function(){
			updateRange();
			var date = new Date($(".timepicker").val());
			if (+$(this).val() != date.getFullYear()){
				$(".timepicker").val(defaultDate());
			}
		});
		
		$("#Games_Teams_idteam_home, #Games_Teams_idteam_visiting").change(function(){
			if ($("#Games_Teams_idteam_home").val() == $("#Games_Teams_idteam_visiting").val() && $("#Games_Teams_idteam_home").val()!=""){
				alert("You can not choose same team for Home and Visiting.");
				$("#Games_Teams_idteam_visiting").val(null);
			}
		});
		
		setTimeout(function(){
			$("#Games_season_idseason").change();
		},50);
	})();
</script>