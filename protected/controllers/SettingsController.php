<?php

class SettingsController extends Controller
{
	public $layout='//layouts/column2';
	
	public function actionChange()
	{
		$model = Settings::get();
		$this->performAjaxValidation($model);
		
		if(isset($_POST['Settings'])){
			$model->attributes = $_POST['Settings'];
			if($model->validate()){
				if($model->save()){
					$this->redirect(array('principal/admin'));
				}
			}
		}
		
		$this->render('general',array(
			'model'=>$model,
		));
	}
	
	public function filters()
    {
        return array(
            'accessControl'           // required to enable accessRules
        );
    }
	
	public function accessRules()
    {
		return array(
			array('allow',
				'actions'=>array('change'),
				'roles'=>array('admins','scorer','roster'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
    }
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='general-settings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}