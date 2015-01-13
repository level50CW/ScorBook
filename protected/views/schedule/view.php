<?php
/* @var $this GamesController */
/* @var $model Games */
?>


<h1><?php echo "Schedule - " . $model->teamsIdteamHome['Name']. " VS " . $model->teamsIdteamVisiting['Name'] .( $model->date ? ' - ' . date('F j',strtotime($model->date)) : ''); ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model,
                                               'disabled'=>true)); ?>