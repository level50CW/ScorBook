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

	public function actionsetHitterBase()
    {
       // $data = array();
      // $data["myValue"] = "Content updated in AJAX";
 		Yii::app()->user->setState($_POST['hitterBase'],$_POST['id']);
       // $this->renderPartial('_ajaxContent', $data, false, true);
    }
	
	public function actionsetBatterBase()
    {
       // $data = array();
      // $data["myValue"] = "Content updated in AJAX";
 		Yii::app()->user->setState($_POST['BatterBase'],$_POST['id']);
       // $this->renderPartial('_ajaxContent', $data, false, true);
    }
	
	public function actionsubmitBall ()
	{
		$this->actionCreate();
		
		
	}
	
	public function getBatterNumber($model, $idplayer){
		$criteria = new CDbCriteria();
		$criteria->addcondition("Lineup_idlineup=$model->Lineup_idlineup and Inning <= $model->Inning and Players_idplayer=".$idplayer);
		$Batters = Batters::model()->findAll($criteria);
		
		$lastBatter = count($Batters) - 1;
		
		if ($Batters[$lastBatter]->BatterPosition)					
			return $Batters[$lastBatter]->BatterPosition;
		else return 0;
	}
	
	public function actiongetBasesEvent ()
    {
    	$criteria = new CDbCriteria();
		$play = $_POST['play'];
		$play--;
		
		$criteria->addcondition("play=".$play." AND Lineup_idlineup=".$_POST['idlineup']);
		$model = Events::model()->findAll($criteria);
		
		$lastevent = count($model) - 1;
		
		$b1 = $model[$lastevent]->b1;
		$b2 = $model[$lastevent]->b2;
		$b3 = $model[$lastevent]->b3;
		
		Yii::app()->user->setState('b1before',$b1);
		Yii::app()->user->setState('b2before',$b2);
		Yii::app()->user->setState('b3before',$b3);
		
		if ($b1) $batterNumber1 = $this->getBatterNumber($model[$lastevent], $b1);
		else $batterNumber1 = 0;
		
		if ($b2) $batterNumber2 = $this->getBatterNumber($model[$lastevent], $b2);
		else $batterNumber2 = 0;
		
		if ($b3) $batterNumber3 = $this->getBatterNumber($model[$lastevent], $b3);
		else $batterNumber3 = 0;
		
		$array = array($b1,$b2,$b3,$batterNumber1,$batterNumber2,$batterNumber3);
		
		echo json_encode($array);
		
		/* echo "<script> b1 = $b1 </script>";
		echo "<script> </script>";
		echo "<script> </script>"; */
		//Yii::app()->user->setState($_POST['BatterBase'],$_POST['id']);
     
    }
	
	private function checkbases($event){
		
		switch ($event){
			
			default:
				
				/* if (Yii::app()->user->getState('hitterBase3') ){
					Yii::app()->user->setState('hitterBase3',0);
				}
				
				if (Yii::app()->user->getState('hitterBase2') ){
					Yii::app()->user->setState('hitterBase2',0);
					Yii::app()->user->setState('hitterBase3',1);
				}
				
				if (Yii::app()->user->getState('hitterBase1') ){
					Yii::app()->user->setState('hitterBase1',0);
					Yii::app()->user->setState('hitterBase2',1);
				}*/

				
			break;
			
		}
			
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		
		$model=new Events;
		
		$ajax = $_POST['ajax'];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		 if(isset($_POST['Events']))
		{
			
			
			
			
			$count = sizeof($_POST['Events']['Events_type_idevents_type']);
						
				
				for($i=0;$i<$count;$i++)
				{
					//echo $_POST['Events']['Events_type_idevents_type'][$i]."<br>";
					if ($_POST['Events']['Events_type_idevents_type'][$i] != ""){
					
					
			
					$idEve = $_POST['Events']['idevents'][$i];
					
					echo Yii::trace(CVarDumper::dumpAsString($_POST['Statspitching'])."-".$i ,'IDEVE9');
					
					if ($idEve != '' && $idEve && isset($idEve) && $idEve !='undefined' ) {
						$model=$this->loadModel($idEve);
						
					}
					
						
					if (!$idEve) $model=new Events;
					
					$model->attributes=$_POST['Events'];
					
					if (!$idEve) $model->idevents = NULL;
					else $model->idevents = $idEve;
					
					
					
					$model->play = 	$_POST['Events']['play'];	
					$model->turntobat = $_POST['Events']['turntobat'];
					$model->Events_type_idevents_type =$_POST['Events']['Events_type_idevents_type'][$i];
					$model->Misce = $_POST['Events']['Misce'][$i]; 
					$model->text = $_POST['Events']['text'][$i]; 
					$model->RBI = $_POST['Events']['RBI'][$i]; 
					$model->ER = $_POST['Events']['ER'][$i]; 
					$model->Batter = $_POST['Events']['Batter'][$i]; 
					$model->playerid = $_POST['Events']['playerid'][$i]; 
					$model->batterNumberOut = $_POST['Events']['batterNumberOut'][$i]; 
					
					
					$idplayer=$_POST['Statshitting']['Players_idplayer'][0];
							
					//Check turntobat
					if ( $model->Batter > $tmpbat = $_POST['Events']['Batter'][$count-1] ){
						$model->turntobat = $model->turntobat - 1; 
					}		
					
						
					
					switch ($model->Events_type_idevents_type) {
						
						case 2: //3B
							//$this->checkbases('3b');
							//Yii::app()->user->setState('hitterBase3',$idplayer);
							
							//Yii::app()->user->setState('batterNumber3',$model->Batter);
							
						break;
						
						case 3: //2B
							//$this->checkbases('2b');
							//Yii::app()->user->setState('hitterBase2',$idplayer);
							//Yii::app()->user->setState('batterNumber2',$model->Batter);
							
						break;
						
						case 4: //1B
							//$this->checkbases('1b');
						
							//Yii::app()->user->setState('hitterBase1',$idplayer);
							//echo "<script> alert('submit value of BatterNumber1'+$model->Batter) </script>";
							//Yii::app()->user->setState('batterNumber',$model->Batter);
							//Yii::app()->user->setState('batterNumber1',$model->Batter);
						break;
						
						case 5; case 6 : //BB HP
							//$this->checkbases('1b');
							//Yii::app()->user->setState('hitterBase1',$idplayer);
							
							//Yii::app()->user->setState('batterNumber1',$model->Batter);
							//Yii::app()->user->setState('batterNumber',$model->Batter);
						break;
						
						
						case 37:  //Event is out
							
							//increment outs
							Yii::app()->user->setState('outs', Yii::app()->user->getState('outs')+1);
							
							//3 Outs change team
							if (Yii::app()->user->getState('outs') == 3) {
									
								// ???Yii::app()->user->setState('batter', 1); 
								Yii::app()->user->setState('outs', 0); //Clear outs
								
								// ??????Yii::app()->user->setState('inning', Yii::app()->user->getState('inning') + 1) ;
								
								if (Yii::app()->user->getState('battingteam') == Yii::app()->user->getState('idteamhome')) {
									Yii::app()->user->setState('battingteam' , Yii::app()->user->getState('idteamvisiting'));
									
								}else 
									Yii::app()->user->setState('battingteam',  Yii::app()->user->getState('idteamhome')) ;
								
								Yii::app()->user->setState('batter',1) ;
							}
						break;
						
						case 38; case 39; case 40; case 41; case 42:  //Ball Tray // run's 
						$model->text = ''; 
						$model->RBI = ''; 
						$model->ER = ''; 
						$model->ER = ''; 	
						break;
						
						case 77: //Last batter
							Yii::app()->user->setState('outs', 0); //Clear outs
								
							if (Yii::app()->user->getState('battingteam') == Yii::app()->user->getState('idteamhome')) {
								Yii::app()->user->setState('battingteam' , Yii::app()->user->getState('idteamvisiting'));
							}else 
								Yii::app()->user->setState('battingteam',  Yii::app()->user->getState('idteamhome')) ;
							
							Yii::app()->user->setState('batter',1) ;
						break;
						
						
					}
						
						
					/* $model->b1 = Yii::app()->user->getState('hitterBase1'); 
					$model->b2 = Yii::app()->user->getState('hitterBase2'); 
					$model->b3 = Yii::app()->user->getState('hitterBase3'); */
					$model->b1 = $_POST['Events']['b1'][$i]; 
					$model->b2 = $_POST['Events']['b2'][$i];
					$model->b3 = $_POST['Events']['b3'][$i];
					
					
					$model->B1text = $_POST['B1text'];
					$model->B2text = $_POST['B2text'];
					$model->B3text = $_POST['B3text'];
					$model->B4text = $_POST['B4text'];
					$model->OutText = $_POST['OutText'];
					
						
					
						if ( $model->validate() ){
							$model->save();
							$idevents[] = $model->idevents;
						}else{
							print_r($model->errors);
							//echo "ID: $model->idevents -id <br>";
						} 
					
					}
				}
				
				$count = count($_POST['Statshitting']['Players_idplayer']);
				
				for($i=0;$i<$count;$i++)
				{
					if ($_POST['Statshitting']['Players_idplayer']){
						
					
					if ($_POST['Statshitting']['idstatshit'][$i]){
						$stats=Statshitting::model()->findByPk($_POST['Statshitting']['idstatshit'][$i]); // = Statshitting::findByPK();
					}else{
						//Find by ID player and ID game
						$criteria = new CDbCriteria();
						$id_player=$_POST['Statshitting']['Players_idplayer'][$i];
						$id_game=$_POST['Statshitting']['Games_idgame'][$i];
						$criteria->addcondition("Players_idplayer=".$id_player." and Games_idgame = ".$id_game);
						$statsArr = Statshitting::model()->findAll($criteria);
						$stats = $statsArr[0];

						if (!$stats){
							$stats=new Statshitting;
						}
						
						
					}



					$stats->AB= $_POST['Statshitting']['AB'][$i];
					$stats->G= 1;
					$stats->H= $_POST['Statshitting']['H'][$i];
					$stats->RBI= $_POST['Statshitting']['RBI'][$i];
					$stats->BB= $_POST['Statshitting']['BB'][$i];
					$stats->SO= $_POST['Statshitting']['SO'][$i];
					$stats->R= $_POST['Statshitting']['R'][$i];
					$stats->v2B= $_POST['Statshitting']['v2B'][$i];
					$stats->v3B= $_POST['Statshitting']['v3B'][$i];
					$stats->HR= $_POST['Statshitting']['HR'][$i];
					$stats->TB= $_POST['Statshitting']['TB'][$i];
					$stats->IBB= $_POST['Statshitting']['IBB'][$i];
					$stats->HP= $_POST['Statshitting']['HP'][$i];
					$stats->SH= $_POST['Statshitting']['SH'][$i];
					$stats->SF= $_POST['Statshitting']['SF'][$i];
					$stats->SB= $_POST['Statshitting']['SB'][$i];
					$stats->CS= $_POST['Statshitting']['CS'][$i];
					$stats->LOB= $_POST['Statshitting']['LOB'][$i];
					$stats->OE= $_POST['Statshitting']['OE'][$i];
					$stats->FC= $_POST['Statshitting']['FC'][$i];
					$stats->CO= $_POST['Statshitting']['CO'][$i];
					$stats->DP= $_POST['Statshitting']['DP'][$i];
					$stats->TP= $_POST['Statshitting']['TP'][$i];
					$stats->GDP= $_POST['Statshitting']['GDP'][$i];
					$stats->SAC= $_POST['Statshitting']['SAC'][$i];
					$stats->TP= $_POST['Statshitting']['TP'][$i];
					$stats->CS= $_POST['Statshitting']['CS'][$i];
					
					echo Yii::trace(CVarDumper::dumpAsString($stats->H) ,'abzero');
					
					
					if ($stats->AB != 0 ) {
						$stats->AVG = $stats->H / $stats->AB;  // $_POST['Statshitting']['AVG'][$i];
						$stats->OBP = ( $stats->H + $stats->BB + $stats->HBP ) / ($stats->AB + $stats->BB + $stats->HBP + $stats->SF); //$_POST['Statshitting']['OBP'][$i];
						$stats->SLG = $stats->TB / $stats->AB;//$_POST['Statshitting']['SLG'][$i];
						if ( $stats->SLG ) $stats->OPS = $stats->OBP + $stats->SLG; 
						$stats->PA = $stats->AB + $stats->BB + $stats->HBP + $stats->SF;
					}
					
					$stats->Players_idplayer = $_POST['Statshitting']['Players_idplayer'][$i];
					$stats->Games_idgame = $_POST['Statshitting']['Games_idgame'][$i];
					
					$stats->save();
					
					//Set the game in progress
					$game = Games::model()->findByPk( $stats->Games_idgame);
					if (! $game->status ) $game->status = 1;
					$game->save();

                        //buscamos el jugador para poder meterlo en los stats por inning
                        /*$criteria = new CDbCriteria();
                        $id_player = $_POST['Statshitting']['Players_idplayer'][$i];
                        $id_game = $_POST['Statshitting']['Games_idgame'][$i];
                        $criteria->addcondition("Players_idplayer=$id_player and Games_idgame = $id_game");
                        $statsInningArr = Statshittinginning::model()->findAll($criteria);
                        $stats_inning = $statsInningArr[0];

                        if (!$stats_inning){*/
                            $stats_inning = new Statshittinginning;
                       // }

                        $stats_inning->AB = $_POST['Statshitting']['AB'][$i];
                        $stats_inning->G = 1;
                        $stats_inning->H = $_POST['Statshitting']['H'][$i];
                        $stats_inning->RBI = $_POST['Statshitting']['RBI'][$i];
                        $stats_inning->BB = $_POST['Statshitting']['BB'][$i];
                        $stats_inning->SO = $_POST['Statshitting']['SO'][$i];
                        $stats_inning->R = $_POST['Statshitting']['R'][$i];
                        $stats_inning->v2B = $_POST['Statshitting']['v2B'][$i];
                        $stats_inning->v3B = $_POST['Statshitting']['v3B'][$i];
                        $stats_inning->HR = $_POST['Statshitting']['HR'][$i];
                        $stats_inning->TB = $_POST['Statshitting']['TB'][$i];
                        $stats_inning->IBB = $_POST['Statshitting']['IBB'][$i];
                        $stats_inning->HP = $_POST['Statshitting']['HP'][$i];
                        $stats_inning->SH = $_POST['Statshitting']['SH'][$i];
                        $stats_inning->SF = $_POST['Statshitting']['SF'][$i];
                        $stats_inning->SB = $_POST['Statshitting']['SB'][$i];
                        $stats_inning->CS = $_POST['Statshitting']['CS'][$i];
                        $stats_inning->LOB = $_POST['Statshitting']['LOB'][$i];
                        $stats_inning->OE = $_POST['Statshitting']['OE'][$i];
                        $stats_inning->FC = $_POST['Statshitting']['FC'][$i];
                        $stats_inning->CO = $_POST['Statshitting']['CO'][$i];
                        $stats_inning->DP = $_POST['Statshitting']['DP'][$i];
                        $stats_inning->TP = $_POST['Statshitting']['TP'][$i];
                        $stats_inning->GDP = $_POST['Statshitting']['GDP'][$i];
                        $stats_inning->SAC = $_POST['Statshitting']['SAC'][$i];
                        $stats_inning->TP = $_POST['Statshitting']['TP'][$i];
                        $stats_inning->CS = $_POST['Statshitting']['CS'][$i];
                        $stats_inning->Players_idplayer = $_POST['Statshitting']['Players_idplayer'][$i];
                        $stats_inning->Games_idgame = $_POST['Statshitting']['Games_idgame'][$i];
                        $stats_inning->Lineup_idlineup = $model->Lineup_idlineup[$i];
                        $stats_inning->Inning = $model->Inning[$i];

                        echo Yii::trace(CVarDumper::dumpAsString($stats_inning->H) ,'abzero');


                        if ($stats_inning->AB != 0 ) {
                            $stats_inning->AVG = $stats_inning->H / $stats_inning->AB;  // $_POST['Statshitting']['AVG'][$i];
                            $stats_inning->OBP = ( $stats_inning->H + $stats_inning->BB + $stats_inning->HBP ) / ($stats_inning->AB + $stats_inning->BB + $stats_inning->HBP + $stats_inning->SF); //$_POST['Statshitting']['OBP'][$i];
                            $stats_inning->SLG = $stats_inning->TB / $stats_inning->AB;//$_POST['Statshitting']['SLG'][$i];
                            if ( $stats_inning->SLG ) $stats_inning->OPS = $stats_inning->OBP + $stats_inning->SLG;
                            $stats_inning->PA = $stats_inning->AB + $stats_inning->BB + $stats_inning->HBP + $stats_inning->SF;
                        }

                        //$stats_inning->Events_idevent = $model->idevents[$i];

                        $stats_inning->save();
                        //buscamos el jugador para poder meterlo en los stats por inning
					}
				}
				
				$count = count($_POST['Statspitching']['Players_idplayer']);
				
				for($i=0;$i<$count;$i++)
				{
				echo Yii::trace(CVarDumper::dumpAsString($_POST['Statspitching']) ,'entre1');
					
					if ($_POST['Statspitching']['idstatspit'][$i]){
						$stats=Statspitching::model()->findByPk($_POST['Statspitching']['idstatspit'][$i]); // = Statshitting::findByPK();
					}else{
						//Find by ID player and ID game
						$criteria = new CDbCriteria();
						$id_player=$_POST['Statspitching']['Players_idplayer'][$i];
						$id_game=$_POST['Statspitching']['Games_idgame'][$i];
						$criteria->addcondition("Players_idplayer=$id_player and Games_idgame = $id_game");
						$statsArr = Statspitching::model()->findAll($criteria);
						$stats = $statsArr[0];

						if (!$stats){
							$stats=new Statspitching;
						}
						
						
					}	
					
					
					$stats->G= 1;
					$stats->IP = $_POST['Statspitching']['IP'][$i];
					$stats->H = $_POST['Statspitching']['H'][$i];
					$stats->R = $_POST['Statspitching']['R'][$i];
					$stats->BB = $_POST['Statspitching']['BB'][$i];
					$stats->SO = $_POST['Statspitching']['SO'][$i];
					$stats->B = $_POST['Statspitching']['B'][$i];
					$stats->S = $_POST['Statspitching']['S'][$i];
					$stats->BF = $_POST['Statspitching']['BF'][$i];
					$stats->ER = $_POST['Statspitching']['ER'][$i];
					$stats->v2B = $_POST['Statspitching']['v2B'][$i];
					$stats->v3B = $_POST['Statspitching']['v3B'][$i];
					$stats->HR = $_POST['Statspitching']['HR'][$i];
					//$stats->SH = $_POST['Statspitching']['SH'][$i];
					//$stats->SF = $_POST['Statspitching']['SF'][$i];
					$stats->HB = $_POST['Statspitching']['HB'][$i];
					$stats->HBP = $_POST['Statspitching']['HBP'][$i];
					$stats->WP = $_POST['Statspitching']['WP'][$i];
					//$stats->CO = $_POST['Statspitching']['CO'][$i];
					$stats->BK = $_POST['Statspitching']['BK'][$i];
					$stats->G = $_POST['Statspitching']['G'][$i];
					$stats->GS = $_POST['Statspitching']['GS'][$i];
					$stats->CS = $_POST['Statspitching']['CS'][$i];
					$stats->CG = $_POST['Statspitching']['CG'][$i];
					//$stats->CGL = $_POST['Statspitching']['CGL'][$i];
					$stats->W = $_POST['Statspitching']['W'][$i];
					//$stats->LS = $_POST['Statspitching']['LS'][$i];
					//$stats->HO = $_POST['Statspitching']['HO'][$i];
					$stats->SV = $_POST['Statspitching']['SV'][$i];
					$stats->AB = $_POST['Statspitching']['AB'][$i];
					$stats->SB = $_POST['Statspitching']['SB'][$i];
					$stats->NP = $_POST['Statspitching']['NP'][$i];
					$stats->GIDP = $_POST['Statspitching']['GIDP'][$i];
					
					if ($stats->AB){
						$stats->AVG = number_format( $stats->H /$stats->AB,3);
						$stats->SLG = number_format( $stats->BF / $stats->AB,3);
						if ($stats->IP) $stats->WHIP = number_format( ($stats->H + $stats->W) / $stats->IP,3);
					}
					
					if ($stats->W){
						$stats->WPCT = number_format(  $stats->W / ($stats->W + $stats->L),3);
					}
					
					if ($stats->AB || $stats->BB || $stats->HBP || $stats->SF){
						$stats->OBP  = number_format(  ( $stats->H + $stats->BB + $stats->HBP ) / ($stats->AB + $stats->HBP + $stats->BB + $stats->SF),3);
					}
					
					if ($stats->SLG){
						$stats->OPS = number_format(  $stats->OBP / $stats->SLG,3);
					}
					
					if ($stats->IP) {
						$stats->ERA = ($stats->ER * 9 ) / $stats->IP;
					}
					
					$stats->BB_9 = number_format(  $stats->BB / 9,3);
					$stats->H_9 = number_format(  $stats->H / 9,3);
					$stats->K_9 = number_format(  $stats->SO / 9,3);
					
					if ($stats->BB) number_format(  $stats->K_BB = $stats->SO / $stats->BB,3);
					
					if ($stats->IP) number_format(  $stats->P_IP = $stats->NP / $stats->IP,3);
					
					$stats->Players_idplayer = $_POST['Statspitching']['Players_idplayer'][$i];
					$stats->Games_idgame = $_POST['Statspitching']['Games_idgame'][$i];
					
					$stats->save();
					
				} 
				
				$count = count($_POST['Statsfielding']['Players_idplayer']);
				
				
				for($i=0;$i<$count;$i++)
				{
					
					
							
					if ($_POST['Statsfielding']['idstatsfield'][$i]){
						$stats=Statsfielding::model()->findByPk($_POST['Statsfielding']['idstatsfield'][$i]); // = Statshitting::findByPK();
					}else{
						
						//Find by ID player and ID game
						$criteria = new CDbCriteria();
						$id_player=$_POST['Statsfielding']['Players_idplayer'][$i];
						$id_game=$_POST['Statsfielding']['Games_idgame'][$i];
						$criteria->addcondition("Players_idplayer=$id_player and Games_idgame = $id_game");
						$statsArr = Statsfielding::model()->findAll($criteria);
						$stats = $statsArr[0];
						
						if (!$stats){
							$stats=new Statsfielding;
						}
					}
					
					
					$stats->G= 1;
					
					$stats->PO = $_POST['Statsfielding']['PO'][$i];
					$stats->A = $_POST['Statsfielding']['A'][$i];
					$stats->PB = $_POST['Statsfielding']['PB'][$i];
					$stats->INN = $_POST['Statsfielding']['INN'][$i];
					$stats->E = $_POST['Statsfielding']['E'][$i];
					$stats->Games_idgame = $_POST['Statsfielding']['Games_idgame'][$i];
					$stats->Players_idplayer = $_POST['Statsfielding']['Players_idplayer'][$i];
					$stats->A = $_POST['Statsfielding']['A'][$i];
					$stats->DP = $_POST['Statsfielding']['DP'][$i];
					$stats->SB = $_POST['Statsfielding']['SB'][$i];
					$stats->CS = $_POST['Statsfielding']['CS'][$i];
					$stats->C_WP = $_POST['Statsfielding']['C_WP'][$i];
					
					$stats->TC = $stats->PO + $stats->A + $stats->E;
					
					if ($stats->SB || $stats->CS) $stats->SBPCT = $stats->SB /   ( $stats->SB + $stats->CS );
					
					echo Yii::trace(CVarDumper::dumpAsString($stats->PO + $stats->A + $stats->E),'Event12');
					if ($stats->PO +  $stats->A + $stats->E) $stats->FPCT= ( $stats->PO + $stats->A) / ($stats->PO + $stats->A + $stats->E);
					
					if ($stats->INN) $stats->RF = ( $stats->PO + $stats->A) / ($stats->INN);
					
					$stats->save();
					
				}
				
				$count = count($_POST['Runs']['teams_idteam']);
				
				
				for($i=0;$i<$count;$i++)
				{
					if ($_POST['Runs']['idrun'][$i]){
						
						$runs=Runs::model()->findByPk($_POST['Runs']['idrun'][$i]); // = Statshitting::findByPK();
					}else{
						$runs=new Runs;
					}
					
					
					//Load innings from POST
					//for($i=1;$i<10;$i++){
						//$runs->inning.$i = $_POST['Runs']['inning'.$i][$i];
						$runs->inning1 = $_POST['Runs']['inning1'][$i];
						$runs->inning2 = $_POST['Runs']['inning2'][$i];
						$runs->inning3 = $_POST['Runs']['inning3'][$i];
						$runs->inning4 = $_POST['Runs']['inning4'][$i];
						$runs->inning5 = $_POST['Runs']['inning5'][$i];
						$runs->inning6 = $_POST['Runs']['inning6'][$i];
						$runs->inning7 = $_POST['Runs']['inning7'][$i];
						$runs->inning8 = $_POST['Runs']['inning8'][$i];
						$runs->inning9 = $_POST['Runs']['inning9'][$i];
					//}
					
					$runs->R = $_POST['Runs']['R'][$i];
					$runs->H = $_POST['Runs']['H'][$i];
					$runs->E = $_POST['Runs']['E'][$i];
					$runs->teams_idteam = $_POST['Runs']['teams_idteam'][$i];
					$runs->games_idgame= $_POST['Runs']['games_idgame'][$i];
					$runs->save();
					
					
				}
			
			
			//Yii::app()->user->setState('batterNumber', $model->Batter+1); 	
			
			//if($model->save())
				echo Yii::trace(CVarDumper::dumpAsString(Yii::app()->user->getState('batterNumber')),'varSavecount');//$this->redirect(array('view','id'=>$model->idevents));
			
			
			//Increment batter
			
			
			//Change team
			//3 outs change team
				
			
		}

		//echo "<script> alert(".$_POST['link'].")</script>";
		
	 	if ($_POST['link'])
					$this->redirect(array($_POST['link']));
						
		if ($ajax && $idevents){
			echo json_encode($idevents);
		}else{
			$this->render('create',array(
			'model'=>$model,
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
