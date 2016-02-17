<?php

class TeamsController extends Controller
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
                'actions'=>array('delete','create'),
                'roles'=>array('admins','leagueadmin',),
            ),
            array('allow',
                'actions'=>array('update','dynamicteamsHome','dynamicteamsVisiting'),
                'roles'=>array('admins','leagueadmin','teamadmin'),
            ),
            array('allow',
                'actions'=>array('admin','index','view'),
                'roles'=>array('admins','leagueadmin','teamadmin',	'roster',),
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
		$model=new Teams;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Teams']))
		{
			$model->attributes=$_POST['Teams'];
			$model->RGB = $_POST['RGB'];
			$model->logo = '';

			$file = CUploadedFile::getInstance($model,'uploadfile');

			echo Yii::trace(CVarDumper::dumpAsString( $file),'imagevar');

			if($model->validate()){
				$model->save();
				if ($file && $file->name != "") {
					$model->logo = 'images/team_logo/'.$model->primaryKey.$file->name;
					$model->thumb = $model->primaryKey.$file->name;
					$file->saveAs($model->logo);

				}
				$model->save();
				if(isset($_POST['next'])){
					$this->redirect(array('create'));
				} else{
					$this->redirect(array('view','id'=>$model->idteam));
				}
			}


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
		$this->performAjaxValidation($model);
		$logoOri = $model->logo;

		if(isset($_POST['Teams']))
		{

			$model->attributes=$_POST['Teams'];
			$model->uploadfile = isset($_POST['Teams']['uploadfile']) ? $_POST['Teams']['uploadfile'] : null;
			$model->RGB = $_POST['RGB'];
			$model->logo = '';


			$file = CUploadedFile::getInstance($model,'uploadfile');

			echo Yii::trace(CVarDumper::dumpAsString( $file),'imagevar');

			if ($model->validate()) {

				if ($file && ($file->name != "")) {

					$model->logo = 'images/team_logo/'.$model->primaryKey.$file->name;
					$model->thumb = $model->primaryKey.$file->name;
					if ($logoOri) unlink($logoOri);
					$file->saveAs($model->logo);
				}
				$model->save();
				if (isset($_POST['next']))
					$this->redirect(array('update','id'=>$model->next()->idteam));
				$this->redirect(array('view','id'=>$model->idteam));
			}

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

		if ($model->logo) unlink($model->logo);

		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Teams');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Teams('search');
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
	 * @return Teams the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Teams::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Teams $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='teams-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
