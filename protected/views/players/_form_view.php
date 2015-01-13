<?php
$disabledArray= array(
        "disabled"=>"disabled",
        "readonly"=>"readonly",
    );
?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'players-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<div class="clear"></div>

<?php echo $form->errorSummary($model); ?>

<div style='text-align: center'>

    <div class="clear">
    </div>

    <div class="rowdiv">
        <div class="green" style='padding-top: 27px;'>First Name</div>
        <div class="gray" style='padding-top: 27px;'>
            <?php echo $form->textField($model, 'Firstname', array_merge($disabledArray,array('size' => 50, 'maxlength' => 50))); ?>
            <?php echo $form->error($model, 'Firstname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Last Name</div>
        <div class="gray">
            <?php echo $form->textField($model, 'Lastname', array_merge($disabledArray,array('size' => 50, 'maxlength' => 50))); ?>
            <?php echo $form->error($model, 'Lastname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Number</div>
        <div class="gray">
            <?php echo $form->textField($model, 'Number',$disabledArray); ?>
            <?php echo $form->error($model, 'Number'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Team</div>
        <div class="gray">

            <?
            $team_selected = Yii::app()->session['team'];

            if (Yii::app()->session['role'] == 'admins') {
                $teams = Teams::model()->findAll(array('order'=>'Name ASC'));
            } else if (Yii::app()->session['role'] == 'roster') {
                $teams = Teams::model()->findAll(array("condition" => "idteam =  $team_selected",'order'=>'Name ASC'));
            }
            $listTeams = CHtml::listData($teams, 'idteam', 'Name');
            ?>
            <?php //echo $form->dropDownList($model,'Teams_idteam',$listTeams,array('options' => array($team_selected =>array('selected'=>true)))); ?>
            <?php echo $form->dropDownList($model, 'Teams_idteam', $listTeams,array_merge($disabledArray,array("empty"=>"","style"=>"width:216px !important;"))); ?>
            <?php echo $form->error($model, 'Teams_idteam'); ?>
        </div>
    </div>

    <?
    $positions = array('P' => 'P', 'C' => 'C', '1B' => '1B', '2B' => '2B', '3B' => '3B', 'SS' => 'SS',
        'LF' => 'LF', 'CF' => 'CF', 'RF' => 'RF', 'EF' => 'EF', 'DH' => 'DH', 'PH' => 'PH',
        'PR' => 'PR', 'CR' => 'CR', 'EH' => 'EH', 'X' => 'X', 'SF' => 'staff');
    ?>

    <div class="rowdiv">
        <div class="green"> Position</div>
        <div class="gray">

            <?php //echo $form->textField($model,'Position',array('size'=>2,'maxlength'=>2)); ?>
            <?php echo $form->dropDownList($model, 'Position',
                $positions, array_merge($disabledArray,array('class' => 'selectpositions', 'style' => 'width:216px !important; text-align:center', 'options' => array($model->Position => array('selected' => true)))
            ));?>
            <?php echo $form->error($model, 'Position'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Bats</div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Bats', array('R' => 'Right', 'S' => 'Switch', 'L' => 'Left'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'Bats'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Throws</div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Throws', array('R' => 'Right', 'L' => 'Left'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'Throws'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Height</div>
        <div class="gray">
            <?php echo $form->textField($model, 'foot', array_merge($disabledArray,array('style' => 'width:55px !important; text-align:center')));?>
             feet
            <?php echo $form->textField($model, 'inches', array_merge($disabledArray,array('style' => 'width:55px !important; text-align:center')));?>
            inches
            <?php echo $form->error($model, 'Height'); ?>
        </div>
    </div>


    <div class="rowdiv">
        <div class="green"> Weight</div>
        <div class="gray">
            <?php echo $form->textField($model, 'Weight',$disabledArray); ?>
            <?php echo $form->error($model, 'Weight'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Birth Date</div>
        <div class="gray">
         <?php 
            if($model->Birthdate !== null){
                $nda = explode(" ",$model->Birthdate);
                $nda = explode("-", @$nda[0] );
                $model->Birthdate = $nda[1]."-".$nda[2]."-".$nda[0];
            }
            echo $form->textField($model, 'Birthdate', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
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
            <?php echo $form->dropDownList($model, 'State', $states, array_merge($disabledArray, array('style' => 'width:62px !important; text-align:center')));?>
            <?php echo $form->textField($model, 'Hometown', array_merge($disabledArray, array('style' => 'width:140px !important;')));?>
            <?php echo $form->error($model, 'Hometown'); ?>
        </div>
    </div>


    <div class="rowdiv">
        <div class="green"> College</div>
        <div class="gray">
            <?php echo $form->textField($model, 'College',$disabledArray); ?>
            <?php echo $form->error($model, 'College'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Class</div>
        <div class="gray">
            <?php echo $form->textField($model, 'Class',$disabledArray); ?>
            <?php echo $form->error($model, 'Class'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green" style='height: 75px'> Biography</div>
        <div class="gray" style='height: 75px'>
            <?php echo $form->textarea($model, 'Biography',$disabledArray); ?>
            <?php echo $form->error($model, 'Biography'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green" style='height: 60px'> Status</div>
        <div class="gray" style='height: 60px'>
            <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive'), array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>


    <div class='playerphoto'>
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
<br/>
<div class="rowdiv">
        <?php echo CHtml::linkButton('Close',array('submit'=>array('players/admin'),'class'=>'save-form-btn'));?>
</div>
