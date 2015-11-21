<?php

class GamesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('admin','index','view','dynamicteamsHome','dynamicteamsVisiting'),
				'roles'=>array('admins','leagueadmin','teamadmin',	'roster', 'scorer'),
			),
			array('allow',
				'actions'=>array('update'),
				'roles'=>array('admins','leagueadmin','teamadmin', 'scorer'),
			),
			
			array('allow',
				'actions'=>array('create','delete'),
				'roles'=>array('admins','leagueadmin', 'scorer'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Finalize the game
	 */
	public function actionFinalize()
	{
		$id = Yii::app()->user->getState('idgame');
		
		if (!empty($_POST['Games'])){
			$model = $this->loadModel($id);
			
			$model->attributes=$_POST['Games'];
			
			
			$time = date_diff(
				new DateTime($model->dateFromAmericanFormat($model->end_date)),
				new DateTime($model->dateFromAmericanFormat($model->date))
			);
			
			$model->duration = $time->h.':'.$time->i.':'.$time->s;
			
			$model->save();
			
			if ($_POST['link'])
					$this->redirect(array($_POST['link']));
			
			$this->redirect('./index.php');
		}
		
		
		
		$this->render('_finalize',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Games;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Games']))
		{
			$model->attributes=$_POST['Games'];
			$model->unsetAttributes(array('idgame'));
			
			if($model->save()){
				Yii::app()->user->setState('idteamhome', $_POST['Games']['Teams_idteam_home']);
				Yii::app()->user->setState('idteamvisiting', $_POST['Games']['Teams_idteam_visiting']);
				Yii::app()->user->setState('iddivisionhome', $_POST['Games']['Division_iddivision_home']);
				Yii::app()->user->setState('iddivisionvisiting', $_POST['Games']['Division_iddivision_visiting']);
				//echo Yii::trace(CVarDumper::dumpAsString($model->idgame),'vardadd1');
				Yii::app()->user->setState('idgame', $model->idgame);
				
				$this->redirect(array('lineup/create','team'=>'home'));
			}
				
				//$this->redirect(array('view','id'=>$model->idgame));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		

		if(isset($_POST['Games']))
		{
			$model->attributes=$_POST['Games'];
			if($model->save()){
				Yii::app()->user->setState('idteamhome', $_POST['Games']['Teams_idteam_home']);
				Yii::app()->user->setState('idteamvisiting', $_POST['Games']['Teams_idteam_visiting']);
				Yii::app()->user->setState('iddivisionhome', $_POST['Games']['Division_iddivision_home']);
				Yii::app()->user->setState('iddivisionvisiting', $_POST['Games']['Division_iddivision_visiting']);
				//echo Yii::trace(CVarDumper::dumpAsString($model->idgame),'vardadd1');
				Yii::app()->user->setState('idgame', $model->idgame);
				
				if ($_POST['link'])
					$this->redirect(array($_POST['link']));
				
				$this->redirect(array('lineup/create','team'=>'home'));
			}
		}else{
				//Set environment variables on load 
				Yii::app()->user->setState('idteamhome', $model->Teams_idteam_home);
				Yii::app()->user->setState('idteamvisiting', $model->Teams_idteam_visiting);
				
				$criteria = new CDbCriteria();
				$criteria->addcondition("idteam=$model->Teams_idteam_home");
				$Team = Teams::model()->findAll($criteria);
				Yii::app()->user->setState('teamhome',$Team[0]->Name);
				
				$criteria = new CDbCriteria();
				$criteria->addcondition("idteam=$model->Teams_idteam_visiting");
				$Team = Teams::model()->findAll($criteria);
				Yii::app()->user->setState('teamvisiting',$Team[0]->Name);
		}
		
		//Load Lineup
		$criteria = new CDbCriteria();
		$criteria->addcondition("Teams_idteam=$model->Teams_idteam_home AND Games_idgame=$model->idgame");
		$Lineup = Lineup::model()->findAll($criteria);
		@Yii::app()->user->setState('idlineuphome',$Lineup[0]->idlineup);
		
		$criteria = new CDbCriteria();
		$criteria->addcondition("Teams_idteam=$model->Teams_idteam_visiting AND Games_idgame=$model->idgame");
		$Lineup = Lineup::model()->findAll($criteria);
		@Yii::app()->user->setState('idlineupvisiting',$Lineup[0]->idlineup);
		
		
		Yii::app()->user->setState('hitterBase1',0);
		Yii::app()->user->setState('hitterBase2',0);
		Yii::app()->user->setState('hitterBase3',0);
		Yii::app()->user->setState('hitterBase4',0);
		Yii::app()->user->setState('batterNumber1',0);
		Yii::app()->user->setState('batterNumber2',0);
		Yii::app()->user->setState('batterNumber3',0);
		Yii::app()->user->setState('batterNumber4',0);
		Yii::app()->user->setState('battingteam',0);
		Yii::app()->user->setState('inning',0);
		Yii::app()->user->setState('outs',0);
		Yii::app()->user->setState('turntobat',0);
		Yii::app()->user->setState('batter',0);
		
		Yii::app()->user->setState('idgame',$model->idgame);
		
		
		
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Games');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Games('search');
		$model->unsetAttributes();  // clear any default values
		
		$this->updateCurrentState($model);

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Games the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Games::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Games $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='games-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actiondynamicteamsHome()
	{

        if (Yii::app()->session['role'] == 'admins') {
//array(':Division_iddivision'=>(int) $_POST['Games']['Division_iddivision_home'])
            $data=Teams::model()->findAll(array("condition" => "Division_iddivision = ".(int) $_POST['Games']['Division_iddivision_home'],'order' => 'Name'));


        }else if (Yii::app()->session['role'] == 'roster') {

            $team_selected = Yii::app()->session['team'];
            $data = Teams::model()->findAll(array("condition" => "idteam =  $team_selected",'order' => 'Name'));

        }
	 
	    $data=CHtml::listData($data,'idteam','Name');
		echo CHtml::tag('option',array('value'=>''),CHtml::encode("Select Team"),true);
	    foreach($data as $value=>$name)
	    {
	        echo CHtml::tag('option',
	                   array('value'=>$value),CHtml::encode($name),true);
	    }
	}
	
	public function actiondynamicteamsVisiting()
	{
		
	    $data=Teams::model()->findAll('Division_iddivision=:Division_iddivision',
	                  array(':Division_iddivision'=>(int) $_POST['Games']['Division_iddivision_visiting']));
	 
	    $data=CHtml::listData($data,'idteam','Name');
		echo CHtml::tag('option',array('value'=>''),CHtml::encode("Select Team"),true);
	    foreach($data as $value=>$name)
	    {
	        echo CHtml::tag('option',
	                   array('value'=>$value),CHtml::encode($name),true);
	    }
	}
	
	public function actiondynamictDivisions()
	{
	    $data=Division::model()->findAll('league_idleague=:League_idleague',
	                  array(':League_idleague'=>(int) $_POST['Games']['League_idleague']));
	 
	    $data=CHtml::listData($data,'iddivision','Name');
	    foreach($data as $value=>$name)
	    {
	        echo CHtml::tag('option',
	                   array('value'=>$value),CHtml::encode($name),true);
	    }
	}
}
