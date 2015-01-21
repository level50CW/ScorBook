<?php

class PlayersController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','create','update'),
				'users'=>array('@','roster'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('admins','roster'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$fet = explode("-", $model->Height);
		if(count($fet) == 1)
		$fet = explode("'", $model->Height);
		if(count($fet) == 1)
		$fet = explode("`", $model->Height);
		$model->foot = $fet[0];
		$model->inches = $fet[1];

		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->pageTitle = Yii::app()->name." - Add Player";
		$model=new Players;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Players']))
		{
			$model->attributes=$_POST['Players'];
			
			$file = CUploadedFile::getInstance($model,'uploadfile'); 
			$model->Photo = '';
			
			$model->Height =  implode("-", array($_POST['Players']['foot'], $_POST['Players']['inches'] ));
			
			if($model->Birthdate == '') $model->Birthdate = null;

			if($model->validate()){

				$model->save();
				if ($file->name != "") {
					$model->Photo = 'images/players/'.$model->primaryKey.$file->name;
					$model->thumb = $model->primaryKey.$file->name;
					$file->saveAs($model->Photo);
				}
				
				$Player_team = new PlayerTeam;
				
				$Player_team->Players_idplayer = $model->idplayer;
				$Player_team->Teams_idteam = $model->Teams_idteam;
				$Player_team->Date = date('Y-m-d H:i:s');
				
				$Player_team->save();
				
				$model->save();
				if(isset($_POST['next'])){
					$this->redirect(array('create'));
				}else{
					$this->redirect(array('view','id'=>$model->idplayer));
				}
				
			}
		}else{
			$fet = explode("-", $model->Height);
			if(count($fet) == 1)
			$fet = explode("'", $model->Height);
			if(count($fet) == 1)
			$fet = explode("`", $model->Height);
			$model->foot = $fet[0];
			$model->inches = $fet[1];
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$photoOri = $model->Photo;
		
		if(isset($_POST['Players']))
		{
			$model->attributes=$_POST['Players'];
			$model->Photo = '';
			$file = CUploadedFile::getInstance($model,'uploadfile'); 
			
			$model->Height =  implode("-", array($_POST['Players']['foot'], $_POST['Players']['inches'] ));

			if ($model->validate()) {
				if ($file->name != "") {
					$model->Photo = 'images/players/'.$model->primaryKey.$file->name;
					$model->thumb = $model->primaryKey.$file->name;
					if ($photoOri) unlink($photoOri);
					$file->saveAs($model->Photo);
				}else{
                    $model->Photo = $_POST['Players']['Photo'];
                    $model->thumb = $_POST['Players']['thumb'];
                }

			    if($model->Birthdate == '') $model->Birthdate = null;
			    
				$model->save();
				$this->redirect(array('view','id'=>$model->idplayer));
			}

		}else{
			$fet = explode("-", $model->Height);
			if(count($fet) == 1)
			$fet = explode("'", $model->Height);
			if(count($fet) == 1)
			$fet = explode("`", $model->Height);
			$model->foot = $fet[0];
			$model->inches = $fet[1];

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
			
		$model = $this->loadModel($id);
		
		if ($model->Photo) unlink($model->Photo);

        $model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

    /*public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }*/

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Players');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Players('search');
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
	 * @return Players the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Players::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Players $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='players-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
