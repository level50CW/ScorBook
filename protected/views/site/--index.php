<?php
/* @var $this SiteController */


$this->menu=array(
	array('label'=>'Manage Division', 'url'=>array('Division/admin')),
	array('label'=>'Manage Lineup', 'url'=>array('')),
);

$this->pageTitle=Yii::app()->name;
?>

<?
if (Yii::app()->user->name !="Guest") {
	if ( Yii::app()->session['role']  == 'admins'){
		
		$this->redirect('index.php?r=division/admin');
		
	}else if ( Yii::app()->session['role']  == 'scorer'){

			$this->redirect('index.php?r=games/admin');

	}else if ( Yii::app()->session['role']  == 'roster'){

        $this->redirect('index.php?r=players/admin');
    }
}
else
	$this->redirect(array('site/login'));	
	
	
 ?>
	


