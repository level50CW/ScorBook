<?php

/**
 * This is the model class for table "Games".
 *
 * The followings are the available columns in table 'Games':
 * @property integer $idgame
 * @property string $location
 * @property string $date
 * @property string $comment
 * @property integer $attendance
 * @property string $weather
 * @property integer $Teams_idteam_visiting
 * @property integer $Teams_idteam_home
 * @property integer $Division_iddivision_visiting
 * @property integer $Division_iddivision_home
 *
 * The followings are the available model relations:
 * @property GameOfficials[] $gameOfficials
 * @property Teams $teamsIdteamVisiting
 * @property Teams $teamsIdteamHome
 * @property Division $divisionIddivisionVisiting
 * @property Division $divisionIddivisionHome
 * @property Lineup[] $lineups
 */
class Games extends CActiveRecord
{
	
	public $leagueIdleague_Name;
	
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Games the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Games';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            

            array('Teams_idteam_visiting, Teams_idteam_home, Division_iddivision_visiting, Division_iddivision_home,season', 'required'),
            array('idgame, attendance, Teams_idteam_visiting, Teams_idteam_home, Division_iddivision_visiting, Division_iddivision_home, Users_iduser, status, regulation, last_inning, temperature', 'numerical', 'integerOnly'=>true),
            array('location, comment, Plateump, Fieldump1, Fieldump2, Fieldump3, Fieldump4, Fieldump5 ', 'length', 'max'=>200),
            array('weather', 'length', 'max'=>150),
            array('temperature', 'length', 'max'=>4),
            array('winning_team', 'length', 'max'=>8),
            array('half_inning', 'length', 'max'=>6),
            array('date, end_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idgame, location, date, comment, attendance, weather, temperature, Teams_idteam_visiting, Teams_idteam_home, Division_iddivision_visiting, Division_iddivision_home, season, divisionIddivisionHome.league_idleague, leagueIdleague_Name', 'safe', 'on'=>'search'),
            array('idgame, location, date, comment, attendance, weather, temperature, Teams_idteam_visiting, Teams_idteam_home, Division_iddivision_visiting, Division_iddivision_home, season', 'safe', 'on'=>'searchTodayGames'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gameOfficials' => array(self::HAS_MANY, 'GameOfficials', 'Games_idgame'),
            'teamsIdteamVisiting' => array(self::BELONGS_TO, 'Teams', 'Teams_idteam_visiting'),
            'teamsIdteamHome' => array(self::BELONGS_TO, 'Teams', 'Teams_idteam_home'),
            'divisionIddivisionVisiting' => array(self::BELONGS_TO, 'Division', 'Division_iddivision_visiting'),//,'on'=>'divisionIddivisionVisiting.type="division"'),
            'divisionIddivisionHome' => array(self::BELONGS_TO, 'Division', 'Division_iddivision_home'),//,'on'=>'divisionIddivisionVisiting.type="division"'),
            'usersiduser' => array(self::BELONGS_TO, 'Users', 'Users_iduser'),
            'lineups' => array(self::HAS_MANY, 'Lineup', 'Games_idgame'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idgame' => 'Idgame',
            'location' => 'Stadium',
            'season' => 'Season',
            'date' => 'Date Time',
            'comment' => 'Comment',
            'attendance' => 'Attendance',
            'weather' => 'Weather',
            'temperature'=>'temperature',
            'Teams_idteam_visiting' => 'Visiting team',
            'Teams_idteam_home' => 'Home team',
            'Division_iddivision_visiting' => 'Visiting division',
            'Division_iddivision_home' => 'Home division',
            'Teams_name_team_visiting' => 'Visiting team',
            'Teams_name_team_home' => 'Home team',
            'Division_name_division_visiting' => 'Visiting division',
            'Division_name_division_home' => 'Home division',
            'Users_iduser' => 'Scorekeeper',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        if (Yii::app()->session['role'] == 'admins') {

            $criteria->compare('idgame',$this->idgame);
            $criteria->compare('location',$this->location,true);
            $criteria->compare('season',$this->season,true);
            $criteria->compare('date',$this->dateFromAmericanFormat($this->date, false),true);
            $criteria->compare('comment',$this->comment,true);
            $criteria->compare('attendance',$this->attendance);
            $criteria->compare('weather',$this->weather,true);
            $criteria->compare('temperature',$this->temperature,true);
            $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
            $criteria->compare('Teams_idteam_home',$this->Teams_idteam_home);
            $criteria->compare('Division_iddivision_visiting',$this->Division_iddivision_visiting);
            $criteria->compare('Division_iddivision_home',$this->Division_iddivision_home);
			
			$criteria->with=array('divisionIddivisionHome');
			$criteria->compare('divisionIddivisionHome.league_idleague', isset($this->leagueIdleague_Name) && $this->leagueIdleague_Name>-1? $this->leagueIdleague_Name : null);

        } else if (Yii::app()->session['role'] == 'roster') {

            $teamid = Yii::app()->session['team'];

            $criteria->compare('idgame',$this->idgame);
            $criteria->compare('location',$this->location,true);
            $criteria->compare('season',$this->season,true); 
            $criteria->compare('date',$this->dateFromAmericanFormat($this->date, false),true);
            $criteria->compare('comment',$this->comment,true);
            $criteria->compare('attendance',$this->attendance);
            $criteria->compare('weather',$this->weather,true);
            $criteria->compare('temperature',$this->temperature,true);
            $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
            $criteria->compare('Teams_idteam_home',$teamid);
            $criteria->compare('Division_iddivision_visiting',$this->Division_iddivision_visiting);
            $criteria->compare('Division_iddivision_home',$this->Division_iddivision_home);
			
			$criteria->with=array('divisionIddivisionHome');
			$criteria->compare('divisionIddivisionHome.league_idleague', isset($this->leagueIdleague_Name) && $this->leagueIdleague_Name>-1? $this->leagueIdleague_Name : null);
        } else if (Yii::app()->session['role'] == 'scorer') {
            $teamid = Yii::app()->session['team'];
            $criteria->compare('idgame',$this->idgame);
            $criteria->compare('location',$this->location,true);
            $criteria->compare('season',$this->season,true); 
            $criteria->compare('date',date("Y-m-d"),true);
            $criteria->compare('comment',$this->comment,true);
            $criteria->compare('attendance',$this->attendance);
            $criteria->compare('weather',$this->weather,true);
            $criteria->compare('temperature',$this->temperature,true);
            $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
            $criteria->compare('Teams_idteam_home',$teamid);
            $criteria->compare('Division_iddivision_visiting',$this->Division_iddivision_visiting);
            $criteria->compare('Division_iddivision_home',$this->Division_iddivision_home);
			
			$criteria->with=array('divisionIddivisionHome');
			$criteria->compare('divisionIddivisionHome.league_idleague', isset($this->leagueIdleague_Name) && $this->leagueIdleague_Name>-1? $this->leagueIdleague_Name : null);
        }

        $criteria->order = 'date';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function searchTodayGames()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        if (Yii::app()->session['role'] == 'admins') {

        $criteria->compare('idgame',$this->idgame);
        $criteria->compare('location',$this->location,true);
        $criteria->compare('date',date("Y-m-d"),true);
        $criteria->compare('comment',$this->comment,true);
        $criteria->compare('attendance',$this->attendance);
        $criteria->compare('weather',$this->weather,true);
        $criteria->compare('temperature',$this->temperature,true);
        $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
        $criteria->compare('Teams_idteam_home',$this->Teams_idteam_home);
        $criteria->compare('Division_iddivision_visiting',$this->Division_iddivision_visiting);
        $criteria->compare('Division_iddivision_home',$this->Division_iddivision_home);
		

        } else if (Yii::app()->session['role'] == 'roster') {

            $teamid = Yii::app()->session['team'];

            $criteria->compare('idgame',$this->idgame);
            $criteria->compare('location',$this->location,true);
            $criteria->compare('date',$this->date,true);
            $criteria->compare('comment',$this->comment,true);
            $criteria->compare('attendance',$this->attendance);
            $criteria->compare('weather',$this->weather,true);
            $criteria->compare('temperature',$this->temperature,true);
            $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
            $criteria->compare('Teams_idteam_home',$teamid);
            $criteria->compare('Division_iddivision_visiting',$this->Division_iddivision_visiting);
            $criteria->compare('Division_iddivision_home',$this->Division_iddivision_home);
        } else if (Yii::app()->session['role'] == 'scorer') {
            $teamid = Yii::app()->session['team'];
            $criteria->compare('idgame',$this->idgame);
            $criteria->compare('location',$this->location,true);
            $criteria->compare('date',date("Y-m-d"),true);
            $criteria->compare('comment',$this->comment,true);
            $criteria->compare('attendance',$this->attendance);
            $criteria->compare('weather',$this->weather,true);
            $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
            $criteria->compare('Teams_idteam_home',$teamid);
            $criteria->compare('Division_iddivision_visiting',$this->Division_iddivision_visiting);
            $criteria->compare('Division_iddivision_home',$this->Division_iddivision_home);
        }

        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function dateToAmericanFormat($date, $includeTime = true)
    {
        if (empty($date)) {
            return $date;
        }
        $formatFrom = 'Y-m-d' . ($includeTime ? '  H:i:s' : '');
        $dateObj = DateTime::createFromFormat($formatFrom, $date);
        if ($dateObj) {
            $formatTo = 'm-d-Y' . ($includeTime ? '  H:i' : '');
            $date = $dateObj->format($formatTo);
        }
        return $date;
    }

    protected function afterFind()
    {
        // convert to display format
        $this->date = $this->dateToAmericanFormat($this->date);
        $this->end_date = $this->dateToAmericanFormat($this->end_date);
        parent::afterFind();
    }

    public function dateFromAmericanFormat($date, $includeTime = true)
    {
        if (empty($date)) {
            return $date;
        }
        $formatFrom = 'm-d-Y' . ($includeTime ? '  H:i' : '');
        $dateObj = DateTime::createFromFormat($formatFrom, $date);
        if ($dateObj) {
            $formatTo = 'Y-m-d' . ($includeTime ? '  H:i' : '');
            $date = $dateObj->format($formatTo);
        }
        return $date;
    }
	
	public function next()
	{
		$nextModel = $this->find('idgame>:id ORDER BY idgame', array(':id'=>$this->idgame));
		if (count($nextModel) == 0)
			$nextModel = $this->find(' 1 ORDER BY idgame');
		return $nextModel;
	}

    protected function beforeValidate()
    {
        // convert to storage format
        // Not used yet as validation for date is not set in current implementation
        $this->date = $this->dateFromAmericanFormat($this->date);
        $this->end_date = $this->dateFromAmericanFormat($this->end_date);
        return parent::beforeValidate ();
    }
}