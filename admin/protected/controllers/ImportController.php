<?php

class ImportController extends Controller
{
	public $layout='//layouts/column2';
	
	private $parseMessage = '';
	
	private function scheduleProcessRow($row)
	{
		if (count($row) != 9){
			$this->parseMessage = 'Invalid columns number';
			return $rows;
		}
		
		$leagueName = $row[0].' League';
		$season = $row[1];
		$date = $row[2];
		$time = $row[3];
		$timeStandart = $row[4];
		$homeDivisionName = $row[5].' Division';
		$homeTeamName = $row[6];
		$visitorDivisionName = $row[7].' Division';
		$visitorTeamName = $row[8];
		
		
		$ldtCommand = Yii::app()->db->createCommand('SELECT DISTINCT d.`league_idleague`, l.`Name` AS `LN`, d.`iddivision`, d.`Name` AS `DN`, t.`idteam`, t.`Name` AS TN, t.`location`
												FROM `teams` t
												JOIN `division` d ON t.`Division_iddivision`=d.`iddivision`
												JOIN `league` l ON l.`idleague`=d.`league_idleague`
                                                WHERE t.`Name`=:team AND d.`Name`=:division AND l.`Name`=:league');
		$homeResult = $ldtCommand->queryAll(true, array(':league'=>$leagueName, ':division'=>$homeDivisionName, ':team'=>$homeTeamName));
		if (count($homeResult)==0)
		{
			$this->parseMessage = "Combination $leagueName -> $homeDivisionName -> $homeTeamName is not exist";
			return false;
		}
		
		$visitorResult = $ldtCommand->queryAll(true, array(':league'=>$leagueName, ':division'=>$visitorDivisionName, ':team'=>$visitorTeamName));
		if (count($homeResult)==0)
		{
			$this->parseMessage = "Combination $leagueName -> $visitorDivisionName -> $visitorTeamName is not exist";
			return false;
		}
		
		$dateObj = DateTime::createFromFormat('m/d/y H:i', "$date $time");
        if (!$dateObj)
		{
			$this->parseMessage = "Invalid time or date ($date $time)";
			return false;
		}
        $dateTime = $dateObj->format('Y-m-d H:i');
		
		$dateObj = DateTime::createFromFormat('Y', $season);
        if (!$dateObj)
		{
			$this->parseMessage = "Invalid season ($season)";
			return false;
		}
		
		$model = new Games;
		$model->location = $homeResult[0]['location'];
		$model->season = $season;
		$model->date = $dateTime;
		$model->Division_iddivision_home = $homeResult[0]['iddivision'];
		$model->Teams_idteam_home = $homeResult[0]['idteam'];
		$model->Division_iddivision_visiting = $visitorResult[0]['iddivision'];
		$model->Teams_idteam_visiting = $visitorResult[0]['idteam'];
		
		if (!($model->validate() && $model->save())){
			$this->parseMessage = "Internal server error";
			return false;
		}
		
		return true;
	}
	
	private function rostersProcessRow($row)
	{
		if (count($row) != 14){
			$this->parseMessage = 'Invalid columns number';
			return $rows;
		}
		
		$leagueName = $row[0].' League';
		$season = $row[1];
		$divisionName = $row[2].' Division';
		$teamName = $row[3];
		$firstName = $row[4];
		$lastName = $row[5];
		$number = $row[6];
		$position = $row[7];
		$bats = $row[8];
		$throws = $row[9];
		$heightFeet = $row[10];
		$heightInches = $row[11];
		$weight = $row[12];
		$class = $row[13];
		
		
		
		$ldtCommand = Yii::app()->db->createCommand('SELECT DISTINCT d.`league_idleague`, l.`Name` AS `LN`, d.`iddivision`, d.`Name` AS `DN`, t.`idteam`, t.`Name` AS TN, t.`location`
												FROM `teams` t
												JOIN `division` d ON t.`Division_iddivision`=d.`iddivision`
												JOIN `league` l ON l.`idleague`=d.`league_idleague`
                                                WHERE t.`Name`=:team AND d.`Name`=:division AND l.`Name`=:league');
		$result = $ldtCommand->queryAll(true, array(':league'=>$leagueName, ':division'=>$divisionName, ':team'=>$teamName));
		if (count($result)==0)
		{
			$this->parseMessage = "Combination $leagueName -> $divisionName -> $teamName is not exist";
			return false;
		}
		
		
		$model = new Players;
		
		$model->Teams_idteam = $result[0]['idteam'];
		$model->Firstname = $firstName;
		$model->Lastname = $lastName;
		$model->Number = $number;
		$model->Position = $position;
		$model->Bats = $bats;
		$model->Throws = $throws;
		$model->foot = +$heightFeet;
		$model->inches = +$heightInches;
		$model->Height = (+$heightFeet).'-'.(+$heightInches);
		$model->Weight = +$weight;
		$model->Class = $class;
		$model->College = '-';
		$model->status = 1;
		
		if (!$model->validate()){
			$this->parseMessage = "Invalid data in row";
			return false;
		}
		
		if (!$model->save()){
			$this->parseMessage = "Internal server error";
			return false;
		}
		
		return true;
	}
	
	private function processCSV($data, $mode)
	{
		$webroot = Yii::getPathOfAlias('webroot');
		$file =  $webroot . '/tmp/data.csv';
		file_put_contents($file, $data);
		$handle = fopen($file, 'r');
		$rows = 0;
		$mode .='ProcessRow';
		
		while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
		
			if (!$this->$mode($row))
			{
				return $rows;
			}
			
			$rows++;
		}
		fclose($handle);
		return $rows;
	}
	
	public function globalAction($mode){
		$model = new Import();
		
		if (isset($_POST['Import'])){
			$model->attributes = $_POST['Import'];

			$this->parseMessage = '';
			if ($model->validate()){
				$model->importedRowsCount = $this->processCSV($model->data, $mode);
				$model->fileImported = $this->parseMessage == '';
			}
			
			$this->render('form',array(
				'model'=>$model,
				'mode'=>$mode,
				'result'=>true,
				'message'=>$this->parseMessage
			));
			return;
		}
		
		$this->render('form',array(
			'model'=>$model,
			'mode'=>$mode,
		));
	}
	
	public function actionSchedule()
	{
		$this->globalAction('schedule');
	}
	
	public function actionRosters()
	{
		$this->globalAction('rosters');
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
				'actions'=>array('schedule','rosters'),
				'roles'=>array('admins','scorer','roster'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
    }
}