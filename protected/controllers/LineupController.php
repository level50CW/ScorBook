<?php

class LineupController extends Controller
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
                'actions'=>array('index','view','AutocompletePlayer'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','dynamicplayers'),
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
        $model = new Lineup;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Lineup']))
        {
            $model->attributes=$_POST['Lineup'];
            
            $idLineup = $_POST['Lineup']['idlineup'];
            $idteam   = $_POST['Lineup']['Teams_idteam'];
            
            $lineup = array();

            if ($idLineup > 0) {
                $criteria = new CDbCriteria();
                $criteria->select = array('idlineup','Teams_idteam');
                $criteria->addcondition("idlineup=$idLineup AND Teams_idteam = $idteam");
                $lineup = Lineup::model()->findAll($criteria);
            }
            
            $count = sizeof($lineup);
            
            echo @Yii::trace(CVarDumper::dumpAsString($criteria),'varsearch');
            echo @Yii::trace(CVarDumper::dumpAsString($count),'varsearch1');
            
            
            if ($count > 0) {
                $model=$this->loadModel(array('idlineup'=>$idLineup, 'Teams_idteam'=>$idteam) );
                //$model=Lineup::model()->findByPk($idLineup,$idteam);
                $model->attributes=$_POST['Lineup'];
            }
            else $model->unsetAttributes(array('idlineup'));
            
            $model->save();
            
            //echo Yii::trace(CVarDumper::dumpAsString($model),'vardadd0');
            
            //if($model->save()){
                //DELETE LINEUP (BATTERS) TO UPDATE
                Batters::model()->deleteAll("Lineup_idlineup = ".$model->idlineup);
    

                $count = empty($_POST['Batters']) ? 0 : sizeof($_POST['Batters']['Number']);

                for($i=0;$i<$count;$i++)
                {
                
                $Batter = new BATTERS;
                $Batter->Number = $_POST['Batters']['Number'][$i];
                $Batter->Players_idplayer = $_POST['Players']['idplayer'][$i];
                $Batter->Inning = $_POST['Batters']['Inning'][$i];
                $Batter->DefensePosition = $_POST['Batters']['DefensePosition'][$i];
                $Batter->BatterPosition = $_POST['Batters']['BatterPosition'][$i];
                $Batter->Lineup_idlineup = $model->idlineup;

                    if($Batter->validate())
                    {
                            if ($Batter->Number && $Batter->Inning){
                                $Batter->save();


                            }
                            echo Yii::trace(CVarDumper::dumpAsString($Batter),'varSave');
                           // $model->resultado = implode(', ', $model->attributes);
                            //$this->render('index', array ('model' => $model));
                    }
                    else {
                            $errores = $Batter->getErrors();
                            
                           // $this->render('index', array('model' => $errores));
                    }
                
                }

                if ($model->Teams_idteam == Yii::app()->user->getState('idteamhome')){
                    Yii::app()->user->setState('idlineuphome', $model->idlineup);
					Yii::app()->user->setState('batterHomeCount',Batters::getCountInLineup($model->idlineup));
                }
                else {
                    Yii::app()->user->setState('idlineupvisiting', $model->idlineup);
					Yii::app()->user->setState('batterVisitingCount',Batters::getCountInLineup($model->idlineup));
                }
                
                $luh = Yii::app()->user->getState('idlineuphome') ? 1 : 0;
                $luv =  Yii::app()->user->getState('idlineupvisiting') ? 1 : 0;
                
                if ($_POST['link'] && $luh && $luv)
                    $this->redirect(array($_POST['link']));
                
                if ($model->Teams_idteam == Yii::app()->user->getState('idteamhome')){
                    $this->redirect(array('create','team'=>'visiting'));
                }
                else {
                    $this->redirect(array('create','team'=>'home'));
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
        // $this->performAjaxValidation($model);

        if(isset($_POST['Lineup']))
        {
            $model->attributes=$_POST['Lineup'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->idlineup));
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
        $dataProvider=new CActiveDataProvider('Lineup');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Lineup('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Lineup']))
            $model->attributes=$_GET['Lineup'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Lineup the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //$model=$this->loadModel(array('idlineup'=>$idLineup, 'Teams_idteam'=>$idteam) );
        
        $model=Lineup::model()->findByPk($id);
        
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Lineup $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='lineup-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionAutocompletePlayer () {
      if (isset($_GET['term'])) {
        $criteria=new CDbCriteria;
        $criteria->alias = $_GET['column'];
        $criteria->condition = "".$_GET['column']." like '" . $_GET['term'] . "%' ";
    
        $dataProvider = new CActiveDataProvider(get_class(Players::model()), array(
    'criteria'=>$criteria,
    ));
        $projects = $dataProvider->getData();
    
        $return_array = array();
        foreach($projects as $project) {
          $return_array[] = array(
                        'label'=>$project->$_GET['column'],
                        'value'=>$project->$_GET['column'],
                        'idplayer'=>$project->idplayer,
                        );
        }
    
        echo CJSON::encode($return_array);
      }
    }
    
    public function actiondynamicplayers()
    {
        
        $data = Players::model()->find('idplayer=:idplayer', 
                      array(':idplayer'=>(int)$_POST['idplayer']));

        echo $data->Number.';'.$data->Position;
        /*$data=CHtml::listData($data,'idplayer','Number');
        foreach($data as $value=>$name)
        {
            //echo CHtml::tag('option',
            //           array('value'=>$value),CHtml::encode($name),true);
            echo CHtml::encode($name);
        }*/

        /*$dataDrop=CHtml::listData($data,'Position','Position');
        foreach($dataDrop as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }*/
       
    }   
}
