<?php
/* @var $this LineupController */
/* @var $model Lineup */
/* @var $form CActiveForm */
?>



<?

if ($_GET['team']) {
    if ($_GET['team'] == 'home') $model->Teams_idteam = Yii::app()->user->getState('idteamhome');
    else $model->Teams_idteam = Yii::app()->user->getState('idteamvisiting');

} else $model->Teams_idteam = Yii::app()->user->getState('idteamhome');

//Yii::app()->user->setState('iddivisionhome', $_POST['Games']['Division_iddivision_home']);
//Yii::app()->user->setState('iddivisionvisiting', $_POST['Games']['Division_iddivision_visiting']);

$model->Games_idgame = Yii::app()->user->getState('idgame');

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
echo Yii::trace(CVarDumper::dumpAsString($model->idlineup), 'idlineup');

?>

<head>
    <script src="js/jquery-1.9.1.js"></script>
</head>

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


<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php echo $form->hiddenField($model, 'idlineup'); ?>
    <?php echo $form->error($model, 'idlineup'); ?>
</div>


<table id='lineup'>


    <div id="tags">
        <div>


            <?php //LOAD PLAYERS

            $criteria = new CDbCriteria();
            $criteria->select = array('idplayer', 'Firstname');
            $criteria->addcondition("Teams_idteam=$model->Teams_idteam");


            $Player = new Players;
            $Players = CHtml::listData(Players::model()->findAll($criteria), 'idplayer', 'Firstname');
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


            for ($i = 0; $i < $count; $i++) {
                ?>
                <?
                $Player->idplayer = $BattersStored[$i]->Players_idplayer;
                ?>

                <?
                $bat = 1 + $i;
                if ($BattersStored[$i]['Inning'] == 1) {

                    echo '<div class="blacktitle"> <TR> <TD>  Batter ' . $bat . ' </TD> </TR> </div>';
                }


                ?>

                <TR class="clone" id="copy">


                    <td>
                        <?php echo $form->textField($BattersStored[$i], 'Number[]', array('value' => $BattersStored[$i]['Number'])
                        ); ?>
                    </td>


                    <td>
                        <? //echo Yii::trace(CVarDumper::dumpAsString($Players),'players1'); ?>
                        <?php echo $form->dropDownList($Player, 'idplayer[]',
                            $Players, array('options' => array($Player->idplayer => array('selected' => true)))
                        );?>
                    </td>

                    <td>
                        <?php echo $form->dropDownList($BattersStored[$i], 'DefensePosition[]',
                            $positions, array('class' => 'selectpositions', 'options' => array($BattersStored[$i]->DefensePosition => array('selected' => true)))
                        );?>

                        <?php echo $form->hiddenField($BattersStored[$i], 'BatterPosition[]',
                            array('value' => $bat)
                        );?>

                    </td>

                    <td>
                        <?php echo $form->textField($BattersStored[$i], 'Inning[]', array('value' => $BattersStored[$i]['Inning'])
                        );?>
                        <?php echo $form->error($Batters, 'Inning'); ?>
                    </td>
                </tr>



                <? //CHECK IF NEXT BATTER IS INNING 1 OR SUBSTITUTION
                if ($bat <= $count)
                    if ($BattersStored[$bat]['Inning'] == 1 || $BattersStored[$bat]['Inning'] == '') {
                        ?>
                        <tr>
                            <td>
                                <a href="#" class="copy">Enter Substitution</a>
                            </td>
                        </tr>
                    <?
                    }


                ?>

            <?

            }

            echo Yii::trace(CVarDumper::dumpAsString($BattersStored), 'Batters11');

            ?>





            <?

            //PRINT 11 BATTERS
            for ($i = $count + 1; $i < 12; $i++) {

                echo '<div class="blacktitle">   Batter ' . $i . ' </div>';


                ?>

                <TR class="clone" id="copy">

                    <td>
                        <?php echo $form->textField($Batters, 'Number[]'); ?>
                    </td>


                    <td>
                        <? //echo Yii::trace(CVarDumper::dumpAsString($Players),'players1'); ?>
                        <?php echo $form->dropDownList($Player, 'idplayer[]',
                            $Players);?>
                    </td>

                    <td>
                        <?php echo $form->dropDownList($Batters, 'DefensePosition[]',
                            $positions, array('class' => 'selectpositions'));?>

                        <?php echo $form->hiddenField($Batters, 'BatterPosition[]', array('value' => $i));?>

                    </td>

                    <td>
                        <?php echo $form->textField($Batters, 'Inning[]'); ?>
                        <?php echo $form->error($Batters, 'Inning'); ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="#" class="copy">Enter Substitution</a>
                    </td>
                </tr>

            <?
            }

            ?>


        </div>

</table>


<div class="row">
    <?php echo $form->hiddenField($model, 'Games_idgame'); ?>
    <?php echo $form->error($model, 'Games_idgame'); ?>
</div>

<div class="row">
    <?php echo $form->hiddenField($model, 'Teams_idteam'); ?>
    <?php echo $form->error($model, 'Teams_idteam'); ?>
</div>

<?
echo CHtml::hiddenField('link', '', array('id' => 'link'));
?>

<div class="row buttons">
    <?php echo CHtml::submitButton($model->Teams_idteam == Yii::app()->user->getState('idteamhome') ? 'Visitor' : 'Home'); ?>
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->