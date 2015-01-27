<?php

class ScoreGameController extends Controller
{
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
                'actions'=>array('index','view','dynamicteamsHome','dynamicteamsVisiting'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','finalize'),
                'roles'=>array('admins','scorer'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','view'),
                'roles'=>array('roster'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'roles'=>array('admins','scorer'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionAdmin()
    {
        $model = new Games('searchTodayGames');
        $model->unsetAttributes();
        if(isset($_GET['Games'])){
            $model->attributes=$_GET['Games'];
        }

        if (isset($_POST['link']))
                    $this->redirect(array($_POST['link']));

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate()
    {

        $id = Yii::app()->request->getParam('id');

        $model = $id ? $this->loadModel($id) : new Games;
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        
        if(isset($_POST['Games']))
        {
            $model->attributes = $_POST['Games'];

            if($model->save()){

                Yii::app()->user->setState('idteamhome',       $_POST['Games']['Teams_idteam_home']);
                Yii::app()->user->setState('idteamvisiting',   $_POST['Games']['Teams_idteam_visiting']);
                Yii::app()->user->setState('iddivisionhome',     $_POST['Games']['Division_iddivision_home']);
                Yii::app()->user->setState('iddivisionvisiting', $_POST['Games']['Division_iddivision_visiting']);
                // TODO: verify if there are cases when Yii::app()->db->lastInsertID is required
                $gameId = empty($id) ? Yii::app()->db->lastInsertID : $id;
                Yii::app()->user->setState('idgame', $gameId);
            }

            if ($_POST['link']) {
                $this->redirect(array($_POST['link']));
            }
                
            $this->redirect(array('lineup/create','team'=>'home'));

        }else if($id){
            //Set environment variables on load 
            Yii::app()->user->setState('idteamhome',     $model->Teams_idteam_home);
            Yii::app()->user->setState('idteamvisiting', $model->Teams_idteam_visiting);
            
            $criteria = new CDbCriteria();
            $criteria->addcondition("idteam=$model->Teams_idteam_home");
            $Team = Teams::model()->findAll($criteria);
            Yii::app()->user->setState('teamhome',$Team[0]->Name);
            
            $criteria = new CDbCriteria();
            $criteria->addcondition("idteam=$model->Teams_idteam_visiting");
            $Team = Teams::model()->findAll($criteria);
            Yii::app()->user->setState('teamvisiting',$Team[0]->Name);
    
    
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
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionView($id = null)
    {
        if(!$id) $this->redirect(array('admin'));
        
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }
    
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function loadModel($id)
    {
        $model=Games::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    
}