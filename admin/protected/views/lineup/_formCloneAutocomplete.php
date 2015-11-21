<?php
/* @var $this LineupController */
/* @var $model Lineup */
/* @var $form CActiveForm */
?>


<script type="text/javascript">

    $(document).ready(function () {
        var myTags = ["aaa", "PHP", "Perl", "Python"];
        $('body').delegate('input.ui-autocomplete-input', 'focusin', function () {
            if ($(this).is(':data(autocomplete)')) return;
            $(this).autocomplete({
                "source": myTags
            });
        });
        var tagsdiv = $('#tags');
        $('body').delegate('a.copy', 'click', function (e) {
            e.preventDefault();
            $(this).closest('tr').prev().after($(this).closest('tr').prev().clone());
        });
    });
</script>


<?
$positions = array('1' => 'P', '2' => 'C', '3' => '1B', '4' => '2B', '5' => '3B', '5' => 'SS',
    '6' => 'LF', '7' => 'CF', '8' => 'RF', '9' => 'EF', '10' => 'DH', '11' => 'PH',
    '12' => 'PR', '13' => 'CR', '14' => 'EH', '15' => 'X');
?>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'lineup-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'idlineup'); ?>
        <?php echo $form->textField($model, 'idlineup'); ?>
        <?php echo $form->error($model, 'idlineup'); ?>
    </div>


    <table id='lineup'>
        <thead>
        <tr>
            <th>Number</th>
            <th>Name</th>
            <th>Position</th>
            <th>Inning</th>
        </tr>
        </thead>

        <div id="tags">
            <div>


                <TR class="clone" id="copy">


                    <?php

                    $Players = new Players;
                    $Batters = new Batters;
                    ?>

                    <td>
                        <?php echo $form->textField($Batters, 'Number[]'); ?>
                    </td>

                    <?
                    $autocompleteConfig = array(
                        'model' => $Players,
                        'attribute' => 'idplayer[]',
                        'source' => $this->createUrl('lineup/autocompletePlayer&column=Firstname'),
                        'htmlOptions' => array('placeholder' => 'Any'),
                        'options' =>
                        array(
                            'showAnim' => 'fold',
                            'select' => "js:function(project, ui) {
	                  $('#ZbProjects_projects_id').val(ui.item.id);
	                         }"
                        ),
                        'cssFile' => false,
                    );

                    //WIDGET AUTCOMPLETE
                    ?>
                    <TD>
                        <?php echo $form->labelEx($Players, 'Firstname'); ?>
                        <?php $this->widget('CAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'profile',
                            'url' => $this->createUrl('profile/suggest'),
                            'multiple' => false,
                            'htmlOptions' => array('size' => 10),
                        )); ?>

                        <?php    $this->widget('zii.widgets.jui.CJuiAutoComplete', $autocompleteConfig); ?>
                    </TD>



                    <?php

                    //$this->widget('ext.jqrelcopy.JQRelcopy',
                    //               array(
                    //                     'id' => 'copylink',
                    //                     'removeText' => 'Remove',


                    //                      ));

                    ?>


                    <td>
                        <?php echo $form->dropDownList($Batters, 'Position[]',
                            $positions);?>
                    </td>

                    <td>
                        <?php echo $form->textField($model, 'Inning'); ?>
                        <?php echo $form->error($model, 'Inning'); ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="#" class="copy">Copy</a>
                    </td>
                </tr>

                <?php echo $form->labelEx($model, 'Inning'); ?>
                <?php echo $form->textField($model, 'Inning'); ?>
                <?php echo $form->error($model, 'Inning'); ?>

            </div>

    </table>


    <div class="row">
        <?php echo $form->labelEx($model, 'Games_idgame'); ?>
        <?php echo $form->textField($model, 'Games_idgame'); ?>
        <?php echo $form->error($model, 'Games_idgame'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->