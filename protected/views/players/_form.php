<?php
/* @var $this PlayersController */
/* @var $model Players */
/* @var $form CActiveForm */
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
        <div class="green" style='padding-top: 27px;'>First Name<span class="required">*</span></div>
        <div class="gray" style='padding-top: 27px;'>
            <?php echo $form->textField($model, 'Firstname', array('size' => 50, 'maxlength' => 50)); ?>
            <?php echo $form->error($model, 'Firstname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Last Name<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'Lastname', array('size' => 50, 'maxlength' => 50)); ?>
            <?php echo $form->error($model, 'Lastname'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Number<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'Number'); ?>
            <?php echo $form->error($model, 'Number'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Team<span class="required">*</span></div>
        <div class="gray">

            <?
            $team_selected = Yii::app()->session['team'];

            if (Yii::app()->session['role'] == 'admins') {
                $teams = Teams::model()->findAll(array('order'=>'Name ASC'));
            } else if (Yii::app()->session['role'] == 'roster') {
                $teams = Teams::model()->findAll(array("condition" => "idteam = $team_selected",'order'=>'Name ASC'));
            }
            $listTeams = CHtml::listData($teams, 'idteam', 'Name');
            ?>
            <?php //echo $form->dropDownList($model,'Teams_idteam',$listTeams,array('options' => array($team_selected =>array('selected'=>true)))); ?>
            <?php echo $form->dropDownList($model, 'Teams_idteam', $listTeams,array("empty"=>"Select a Team","style"=>"width:216px !important;")); ?>
            <?php echo $form->error($model, 'Teams_idteam'); ?>
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
                $positions, array('class' => 'selectpositions', 'style' => 'width:216px !important; text-align:center', 'options' => array($model->Position => array('selected' => true)))
            );?>
            <?php echo $form->error($model, 'Position'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Bats<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Bats', array('R' => 'Right', 'S' => 'Switch', 'L' => 'Left'), array('style' => 'width:216px !important; text-align:center'));?>
            <?php echo $form->error($model, 'Bats'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Throws<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'Throws', array('R' => 'Right', 'L' => 'Left'), array('style' => 'width:216px !important; text-align:center'));?>
            <?php echo $form->error($model, 'Throws'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Height<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'foot', array("4"=>"4","5"=>"5","6"=>"6","7"=>"7",), array('style' => 'width:65px !important; text-align:center'));?>
             feet
            <?php echo $form->dropDownList($model, 'inches', array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11"), array('style' => 'width:65px !important; text-align:center'));?>
            inches
            <?php //echo $form->textField($model, 'Height'); ?>
            <?php echo $form->error($model, 'Height'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Weight<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'Weight'); ?>
            <?php echo $form->error($model, 'Weight'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Birth Date</div>
        <div class="gray">
            <?php
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
            <?php echo $form->dropDownList($model, 'State', $states, array('style' => 'width:62px !important; text-align:center'));?>
            <?php echo $form->textField($model, 'Hometown', array('style' => 'width:140px !important;'));?>
            <?php echo $form->error($model, 'Hometown'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> College<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->textField($model, 'College'); ?>
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
                echo $form->dropDownList($model, 'Class', $years, array('style' => 'width:216px !important; text-align:center'));?>
            <?php echo $form->textField($model, 'Class'); ?>
            <?php echo $form->error($model, 'Class'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green" style='height: 75px'> Biography</div>
        <div class="gray" style='height: 75px'>
            <?php echo $form->textarea($model, 'Biography'); ?>
            <?php echo $form->error($model, 'Biography'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green"> Status<span class="required">*</span></div>
        <div class="gray">
            <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive'), array('style' => 'width:216px !important; text-align:center'));?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <div class="rowdiv">
        <div class="green" style='height: 60px'> Photo</div>
        <div class="gray" style='height: 60px'>
            <?php
            echo $form->fileField($model, 'uploadfile', array('class' => 'filebutton'));
            echo $form->error($model, 'uploadfile');
            echo $form->hiddenField($model,'Photo');
            echo $form->hiddenField($model,'thumb');
            ?>
        </div>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array("class"=>"save-form-btn")); ?>
        <?php echo CHtml::submitButton(($model->isNewRecord ? 'Add' : 'Update').'/Next',array("class"=>"save-form-btn",'onclick'=>"$('form').append('<input name=\"next\" value=\"true\" style=\"display:none\">');")); ?>
        <?php echo CHtml::linkButton('Close',array(
			'submit'=>array(
				'players/admin',
				'Players_page'=>isset(Yii::app()->session['Players_page']) ? Yii::app()->session['Players_page'] : 1),
			'class'=>'save-form-btn')); ?>
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