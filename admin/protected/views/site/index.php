<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?
if (Yii::app()->user->name !="Guest") {
	$this->redirect('index.php?r=principal/admin');
	// if ( Yii::app()->session['role']  == 'admins'||){
		// $this->redirect('index.php?r=principal/admin');
	// } else if ( Yii::app()->session['role']  == 'scorer'){
		// $this->redirect('index.php?r=games/admin');
	// } else if ( Yii::app()->session['role']  == 'roster' || Yii::app()->session['role']  == 'teamadmin'){
		// $this->redirect('index.php?r=players/admin');
	//}
}
else
	$this->redirect(array('site/login'));	
	
	
 ?>
	


