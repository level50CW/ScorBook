<?php
/* @var $this GamesController */
/* @var $model Games */
?>


<h1><?php
    $modelDate = date_create_from_format('m-d-Y H:i', $model->date);
    echo "Schedule - " . $model->teamsIdteamHome['Name']. " VS " . $model->teamsIdteamVisiting['Name'] .( !empty($modelDate) ? ' - ' . date_format($modelDate,'F j') : ''); ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model,
                                               'disabled'=>true)); ?>