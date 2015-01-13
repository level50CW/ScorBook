<?php
/* @var $this LineupController */
/* @var $model Lineup */
/* @var $form CActiveForm */
?>


	<? //LOAD LINEUP 
	
	$criteria = new CDbCriteria();
	$criteria->addcondition("Games_idgame=$model->Games_idgame AND Teams_idteam=$model->Teams_idteam");
	
	$lineup = new Lineup;
	$lineup = Lineup::model()->findAll($criteria);
	//$idlineup = $lineup->idlineup
	
	if ($lineup[0]->idlineup) $model->idlineup = $lineup[0]->idlineup;
	
	/* $Player = new Players;
	$Players = CHtml::listData(Players::model()->findAll($criteria),'idplayer','Firstname');
	$Batters = new Batters;	?>
       */    
	echo Yii::trace(CVarDumper::dumpAsString($model->idlineup),'idlineup');
       
  	?>

<head>
<script src="js/jquery-1.9.1.js"></script>
</head>

    <script type="text/javascript">

        $(document).ready(function(){
            var myTags = ["aaa","PHP", "Perl", "Python"];
                        $('body').delegate('input.ui-autocomplete-input', 'focusin', function() {
                            if($(this).is(':data(autocomplete)')) return;
                            $(this).autocomplete({
                                "source": myTags
                            });
                        });
                        var tagsdiv = $('#tags');
                        
                        //DELETE BUTTON
                        var element = document.createElement("input");
 
					    //Assign different attributes to the element.
					    /*element.setAttribute("type", 'button');
					    element.setAttribute("value", 'Delete');
					    element.setAttribute("name", 'Delete');
					    element.setAttribute("onClick", 'deleteSustitution');*/
					    
                        
                        $('body').delegate('a.copy', 'click', function(e) {
                            e.preventDefault();
                            $(this).closest('div').prev().after($(this).closest('div').prev().clone());
                            //$(this).closest('div').prev().after(element);
                            
                        });
        });
    </script>
    

<?
$positions = array('1' => 'P', '2' => 'C', '3' => '1B', '4' => '2B', '5' => '3B', '5' => 'SS',
				  '6' => 'LF', '7' => 'CF', '8' => 'RF', '9' => 'EF', '10' => 'DH', '11' => 'PH',
				  '12' => 'PR', '13' => 'CR', '14' => 'EH', '15' => 'X');
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lineup-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class='redbar' style='height:37px'>
	<div class="rightbutton">
		<?php echo CHtml::imageButton('images/button_options.png', array('onClick'=>'submitLink("games/create")')); ?>
	</div>
	<div class="centerbutton">&nbsp;
		<? if ($_GET['team']=='home') $dis = 'disabled'; else $dis = 'enabled'?>
		<?php echo CHtml::imageButton('images/button_home.png',array($dis=>'true')); ?>
		<? if ($_GET['team']=='visiting') $dis = 'disabled'; else $dis = 'enabled'?>
		<?php echo CHtml::imageButton('images/button_visiting.png',array($dis=>'true') ); ?>
	</div>
</div>
	
	
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'idlineup'); ?>
		<?php echo $form->error($model,'idlineup'); ?>
	</div>



<table id='lineup'>
  	
  	
  	<div id="tags" class="tags">


 	 	
	<?php //LOAD PLAYERS

	$criteria = new CDbCriteria();
	$criteria->select = array('idplayer','Firstname');
	$criteria->addcondition("Teams_idteam=$model->Teams_idteam");
	
	
	$Player = new Players;
	$Players = CHtml::listData(Players::model()->findAll($criteria),'idplayer','Firstname');
	$Batters = new Batters;		
	?>
		
		

	<? 
	
	//LOAD BATTERS 
	if ($model->idlineup) {
		$criteria = new CDbCriteria();
		$criteria->addcondition("Lineup_idlineup = $model->idlineup");
		
		$BattersStored = new Batters;
		$BattersStored = Batters::model()->findAll($criteria);		
	}
	
	$count = sizeof($BattersStored);
	
	
	for($i=0;$i<$count;$i++)
	{
	?>
		<?
		$Player->idplayer = $BattersStored[$i]->Players_idplayer;
		?>
		
		<?
		$bat = 1+$i;
		if ($BattersStored[$i]['Inning'] == 1 ){
			
			echo '<div class="blacktitle"> Batter '. $bat .'  </div>';
		}
			
		
		?>
		
		<div class="grayplayer">

		 		<?php echo $form->textField($BattersStored[$i],'Number[]',array("class"=>"inputnumbers",'value'=>$BattersStored[$i]['Number'])
				); ?>
			<div style="width:340px;display:inline-block;">
				<? //echo Yii::trace(CVarDumper::dumpAsString($Players),'players1'); ?>
				<?php echo $form->dropDownList($Player,'idplayer[]', 
	              $Players,  array('options' => array($Player->idplayer=>array('selected'=>true)))     
				  );?>
	       </div>
				<?php echo $form->dropDownList($BattersStored[$i],'DefensePosition[]', 
	              $positions,   array('class'=>'selectpositions','options' => array($BattersStored[$i]->DefensePosition => array('selected'=>true)))
				  );?>
	
				<?php echo $form->hiddenField($BattersStored[$i],'BatterPosition[]',
				 array('value' => $bat)
				);?>
	       
	        	<?php echo $form->textField($BattersStored[$i],'Inning[]',array("class"=>"inputnumbers",'value'=>$BattersStored[$i]['Inning'])
				);?>
				<?php echo $form->error($Batters,'Inning'); ?>
		</div>
		
		
		<?//CHECK IF NEXT BATTER IS INNING 1 OR SUBSTITUTION
		if ($bat <= $count)
			if ($BattersStored[$bat]['Inning'] == 1 || $BattersStored[$bat]['Inning'] == '') {
		?>
		<div class="black">
		<a href="#" class="copy">Enter Substitution</a>
		</div>
		<div class="clear"> </div>
		<? }
		
		    
		?>
	
	<?
	
	}

	echo Yii::trace(CVarDumper::dumpAsString($BattersStored),'Batters11');
       
  	?>
	
  	
	 
	
	
	<?
	
	//PRINT 11 BATTERS 
	for ($i = $count+1; $i < 12; $i++ ){
		
		echo '<div class="blacktitle">   Batter '. $i .' </div>';
		
		
	?>
		<div class="grayplayer">
		 		<?php echo $form->textField($Batters,'Number[]',array("class"=>"inputnumbers")); ?>
	 	
		
			<? //echo Yii::trace(CVarDumper::dumpAsString($Players),'players1'); ?>
			<div style="width:340px;display:inline-block;">
			<?php echo $form->dropDownList($Player,'idplayer[]', 
              $Players);?>
			</div>
			<?php echo $form->dropDownList($Batters,'DefensePosition[]', 
              $positions,array('class'=>'selectpositions'));?>

			<?php echo $form->hiddenField($Batters,'BatterPosition[]',array('value'=>$i));?>
       
			<?php echo $form->textField($Batters,'Inning[]',array("class"=>"inputnumbers")); ?>
			<?php echo $form->error($Batters,'Inning'); ?>

		</div>
		<div class="black">
		<a href="#" class="copy">Enter Substitution</a>
		</div>
		
		<div class="clear"> </div>
		
	<?
	}
	
	?>
	


     
</table>


	<div class="row">
		<?php echo $form->hiddenField($model,'Games_idgame'); ?>
		<?php echo $form->error($model,'Games_idgame'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->hiddenField($model,'Teams_idteam'); ?>
		<?php echo $form->error($model,'Teams_idteam'); ?>
	</div>
			  
	<?
	echo CHtml::hiddenField('link','',array('id'=>'link'));
	?>
	
	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->Teams_idteam == Yii::app()->user->getState('idteamhome') ? 'Visitor' : 'Home'); ?>
	</div>
	
	<div class="centerbutton1" style='text-align: center'>
		<a onClick="submitLink('atbat')">
		<?php echo CHtml::image('images/button_batterup.png'); ?>
		</a>
	</div>	
  
<?php $this->endWidget(); ?>

</div><!-- form -->

