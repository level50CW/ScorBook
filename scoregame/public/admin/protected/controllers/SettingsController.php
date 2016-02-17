<?php

class SettingsController extends Controller
{
	public $layout='//layouts/column2';
	
	public function actionGeneral()
	{
		$model = Settings::get();
		$this->performAjaxValidation($model);
		
		if(isset($_POST['Settings'])){
			$model->attributes = $_POST['Settings'];
			$model->leagueName = $_POST['Settings']['leagueName'];
			if($model->validate()){
				
				$currentSeason = Season::model()->findByPk($model->idseason);
				$oldSeasons = Season::model()->findAll('season < '.$currentSeason->season);
				for($i=0;$i<count($oldSeasons);$i++){
					$oldSeasons[$i]->status = 2;
					$oldSeasons[$i]->save();
				}
				$newSeasons = Season::model()->findAll('season > '.$currentSeason->season);
				for($i=0;$i<count($newSeasons);$i++){
					$newSeasons[$i]->status = 0;
					$newSeasons[$i]->save();
				}
				$currentSeason->status = 1;
				$currentSeason->save();
				
				$league = League::model()->findByPk($model->idleague);
				$league->Name = $model->leagueName;
				$league->save();
								
				if($model->save()){
					$this->redirect(array('principal/admin'));
				}
			}
		}
		
		$this->render('general',array(
			'model'=>$model,
		));
	}
	
	public function actionSystem()
	{
		$webroot = Yii::getPathOfAlias('webroot');
		$file =  $webroot . '/protected/config/main.php';
		$file2 =  $webroot . '/../protected/config/main.php';
		$data = file_get_contents($file);
		
		eval('$configs = '.substr($data, strpos($data, 'return array')+7));
		$dbConfigs = $configs['components']['db'];
		
		
		$model = new SystemSettings;
		$model->databaseUrl = $dbConfigs['connectionString'];
		$model->databaseUsername = $dbConfigs['username'];
		$model->databasePassword = 'password';
		$model->databaseConfirm = 'password';
		
		if(isset($_POST['SystemSettings'])){
			$databaseUrl = $_POST['SystemSettings']['databaseUrl'];
			$databaseUsername = $_POST['SystemSettings']['databaseUsername'];
			$databasePassword = $_POST['SystemSettings']['databasePassword'];
			$databaseConfirm = $_POST['SystemSettings']['databaseConfirm'];
			$databasePasswordChanged = $_POST['SystemSettings']['databasePasswordChanged'];
			$adminPassword = $_POST['SystemSettings']['adminPassword'];
			
			$model->databaseUrl = $databaseUrl;
			$model->databaseUsername = $databaseUsername;
			
			if ($databasePassword != $databaseConfirm){
				$model->addError('databaseConfirm', 'Password is not confirmed.');
			} else{
				
				try{
					$user = Users::model()->findByPk(Yii::app()->user->id);
					$originalAdminPassword = md5(Yii::app()->user->id.'system-settings-password'.$user->Password);
					Yii::app()->session['system-settings-password'] = $originalAdminPassword;
				}catch (Exception $e) {
					$originalAdminPassword = Yii::app()->session['system-settings-password'];
				}
				
				if (!isset($originalAdminPassword)){
					$model->addError('databaseConfirm', 'Database connection failed. Can not check admin password to save changes.');
				} else {
					$adminPassword = md5(Yii::app()->user->id.'system-settings-password'.md5($adminPassword));
					
					if ($adminPassword != $originalAdminPassword){
						$model->addError('adminPassword','Admin password is invalid. Changes are not applied.');
					}else {
						
						$configStart = strpos($data, '#---this-is-required-comment-for-system-settings---');
						$configEnd = strpos($data, '#---this-is-required-comment-for-system-settings---', $configStart+1);
						
						$configsString = substr($data,$configStart, $configEnd - $configStart);
						$result = eval('$configsData = array('.$configsString.'); return TRUE;');
						if (!$result){
							$model->addError('adminPassword','Config file has errors.');
						}else {
							
							$configsData = $configsData[0];
							$configsData['connectionString'] = $model->databaseUrl;
							$configsData['username'] = $model->databaseUsername;
							if (isset($databasePasswordChanged) && $databasePasswordChanged == $databasePassword)
								$configsData['password'] = $databasePasswordChanged;
							
							$data = str_replace($configsString,
								"#---this-is-required-comment-for-system-settings---\n".var_export($configsData, TRUE).",\n",
								$data);
							
							file_put_contents($file, $data);
							file_put_contents($file2, $data);
							$this->redirect(array('principal/admin'));
							
						}
					}
				}
			}
		}
		
		$this->render('system',array(
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
				'actions'=>array('system'),
				'roles'=>array('admins'),
			),
			array('allow',
				'actions'=>array('general'),
				'roles'=>array('admins','leagueadmin'),
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