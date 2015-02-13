<?php

class EventsController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','setHitterBase','setBatterBase','stats','getBasesEvent'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','scorecard','submitBall'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('admins'),
			),
			/*array('deny',  // deny all users
				'users'=>array('*'),
			),*/
		);
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
		$model=new Events;
		
		$ajax = isset($_POST['ajax']) ? $_POST['ajax'] : array();
		$idevents = null;

	 	if (!empty($_POST['link'])) {
			$this->redirect(array($_POST['link']));
		}
		
		$state = AtBat::loadState();

		Yii::app()->user->setState('battingteam',$state->idteamvisiting);
		$model->Lineup_idlineup = $state->idlineupvisiting;
		$model->Inning = 1;

		$eventsmax        = Events::getByLineupInning($model->Lineup_idlineup, $model->Inning);
		$numb             = (count($eventsmax) > 0) ? (count($eventsmax) - 1) : 0;
		$numberLastBatter = empty($eventsmax[$numb]) ? 0 : $eventsmax[$numb]->Batter;
		Yii::app()->user->setState('batterNumber', $numberLastBatter + 1);
		
		$state = AtBat::loadState(); //reload
		
		$visitingTeamTable = AtBat::loadTableTeam($state->idlineupvisiting, $state);
		$homeTeamTable = AtBat::loadTableTeam($state->idlineuphome, $state);
		$visitingRunsTable = AtBat::loadTableRuns ($state->idgame,$state->idteamvisiting);
		$homeRunsTable = AtBat::loadTableRuns ($state->idgame,$state->idteamvisiting);
		
						
		if ($ajax && $idevents) {
			echo json_encode($idevents);
		} else {
			$this->render('create',array(
				'model'=>$model,
				'state'=>$state,
				'visitingTeamTable'=>$visitingTeamTable,
				'homeTeamTable'=>$homeTeamTable,
				'visitingRunsTable'=>$visitingRunsTable,
				'homeRunsTable'=>$homeRunsTable
			));
			//$this->redirect(array());
		}
		
		

	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionscorecard()
	{
		
		/*if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idevents));
		}*/
		
		if (isset($_POST['link'])) {
			if ($_POST['idevent']){
				$this->redirect(array($_POST['link'],'idevent'=>$_POST['idevent']));
			}		
			
			
			if ($_POST['inning'] && $_POST['turntobat'] && $_POST['batter']){
				$this->redirect(array($_POST['link'],'inning'=>$_POST['inning'],
					'turntobat'=>$_POST['turntobat'],'batter'=>$_POST['batter'], 'update'=>1,
					));
			}
			
			$this->redirect(array($_POST['link']));
		}

		$model = new Events;
		$this->render('scorecard',array(
			'model'=>$model,
		));
	}
	
	public function actionstats()
	{
		if (! Yii::app()->user->getState('scoretype')) Yii::app()->user->setState('scoretype','batting');
		if (! Yii::app()->user->getState('scoretime')) Yii::app()->user->setState('scoretime','game');
		if (! Yii::app()->user->getState('scoreteam')) Yii::app()->user->setState('scoreteam','home');
		


		if(isset($_POST['link']))
		{
			switch ($_POST['link']){
				
				case 'scorehome':
					Yii::app()->user->setState('scoreteam','home');
					break;
				case 'scorevisiting':
					Yii::app()->user->setState('scoreteam','visiting');
					break;
				case 'scoreseason':
					Yii::app()->user->setState('scoretime','season');
					break;
				case 'scoregame':
					Yii::app()->user->setState('scoretime','game');
					break;
				case 'scoresituation':
					Yii::app()->user->setState('scoretime','situation');
					break;
				case 'scorebatting':
					Yii::app()->user->setState('scoretype','batting');
					break;
				case 'scorefielding':
					Yii::app()->user->setState('scoretype','fielding');
					break;
				case 'scorepitching':
					Yii::app()->user->setState('scoretype','pitching');
					break;
					
				default:
					$this->redirect(array($_POST['link']));
				break;
			}
			
		}
		
		//if ($_POST['link'])
		//			$this->redirect(array($_POST['link'],'idevent'=>$_POST['idevent']));
		
		$model = new Events;
		
		$this->render('stats',array(
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idevents));
		}

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
		$dataProvider=new CActiveDataProvider('Events');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Events::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Events $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='events-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
