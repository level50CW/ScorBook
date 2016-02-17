<?php
/* @var $this PlayersController */
/* @var $model Players */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'Firstname'); ?>
        <?php echo $form->textField($model,'Firstname',array('size'=>50,'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'Lastname'); ?>
        <?php echo $form->textField($model,'Lastname',array('size'=>50,'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'Number'); ?>
        <?php echo $form->textField($model,'Number'); ?>
    </div>

    <div class="row">
            <?
            $team_selected = Yii::app()->session['team'];

            if (Yii::app()->session['role'] == 'admins') 
            {
                $teams = Teams::model()->findAll();
            }
            else if (Yii::app()->session['role'] == 'roster')
            {
                $teams = Teams::model()->findAll(array("condition" => "idteam =  $team_selected"));
            }
           
            $listTeams = CHtml::listData($teams, 'idteam', 'Name');
            $listTeams = array_merge(array(''),$listTeams);
            ?>
            
        <?php echo $form->label($model,'Teams_idteam'); ?>
        <?php //echo $form->textField($model,'Teams_idteam'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam', $listTeams); ?>
    </div>

    <div class="row">
         <?
        $positions = array(''=>'    ', 'P' => 'P', 'C' => 'C', '1B' => '1B', '2B' => '2B', '3B' => '3B', 'SS' => 'SS',
            'LF' => 'LF', 'CF' => 'CF', 'RF' => 'RF', 'EF' => 'EF', 'DH' => 'DH', 'PH' => 'PH',
            'PR' => 'PR', 'CR' => 'CR', 'EH' => 'EH', 'X' => 'X', 'SF' => 'staff');
        ?>
        <?php echo $form->label($model,'Position'); ?>
        <?php echo $form->dropDownList($model, 'Position', $positions,
                array('class' => 'selectpositions',
                      'style' => 'width:220px !important; text-align:center',
                      'options' => array($model->Position => array('selected' => true)))
            );?>
        <?php //echo $form->textField($model,'Position',array('size'=>2,'maxlength'=>2)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'Bats'); ?>
        <?php //echo $form->textField($model,'Bats'); ?>
        <?php echo $form->dropDownList($model, 'Bats', array(''=>'','R' => 'Right', 'S' => 'Switch', 'L' => 'Left'), array('style' => 'width:220px !important; text-align:center'));?>
            
    </div>

    <div class="row">
        <?php echo $form->label($model,'Throws'); ?>
        <?php //echo $form->textField($model,'Throws'); ?>
        <?php echo $form->dropDownList($model, 'Throws', array(''=>'','R' => 'Right', 'L' => 'Left'), array('style' => 'width:220px !important; text-align:center'));?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->