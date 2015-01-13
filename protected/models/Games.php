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
 * @property integer $League_idleague_visiting
 * @property integer $League_idleague_home
 *
 * The followings are the available model relations:
 * @property GameOfficials[] $gameOfficials
 * @property Teams $teamsIdteamVisiting
 * @property Teams $teamsIdteamHome
 * @property League $leagueIdleagueVisiting
 * @property League $leagueIdleagueHome
 * @property Lineup[] $lineups
 */
class Games extends CActiveRecord
{
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
            

            array('Teams_idteam_visiting, Teams_idteam_home, League_idleague_visiting, League_idleague_home,season', 'required'),
            array('idgame, attendance, Teams_idteam_visiting, Teams_idteam_home, League_idleague_visiting, League_idleague_home, Users_iduser, status, regulation, last_inning, temperature', 'numerical', 'integerOnly'=>true),
            array('location, comment, Plateump, Fieldump1, Fieldump2, Fieldump3, Fieldump4, Fieldump5 ', 'length', 'max'=>200),
            array('weather', 'length', 'max'=>150),
            array('temperature', 'length', 'max'=>4),
            array('winning_team', 'length', 'max'=>8),
            array('half_inning', 'length', 'max'=>6),
            array('date, end_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idgame, location, date, comment, attendance, weather, temperature, Teams_idteam_visiting, Teams_idteam_home, League_idleague_visiting, League_idleague_home, season', 'safe', 'on'=>'search'),
            array('idgame, location, date, comment, attendance, weather, temperature, Teams_idteam_visiting, Teams_idteam_home, League_idleague_visiting, League_idleague_home, season', 'safe', 'on'=>'searchTodayGames'),
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
            'leagueIdleagueVisiting' => array(self::BELONGS_TO, 'League', 'League_idleague_visiting','on'=>'leagueIdleagueVisiting.type="division"'),
            'leagueIdleagueHome' => array(self::BELONGS_TO, 'League', 'League_idleague_home','on'=>'leagueIdleagueVisiting.type="division"'),
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
            'location' => 'Location',
            'season' => 'Season',
            'date' => 'Date Time',
            'comment' => 'Comment',
            'attendance' => 'Attendance',
            'weather' => 'Weather',
            'temperature'=>'temperature',
            'Teams_idteam_visiting' => 'Visiting team',
            'Teams_idteam_home' => 'Home team',
            'League_idleague_visiting' => 'Visiting league',
            'League_idleague_home' => 'Home league',
            'Teams_name_team_visiting' => 'Visiting team',
            'Teams_name_team_home' => 'Home team',
            'League_name_league_visiting' => 'Visiting league',
            'League_name_league_home' => 'Home league',
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
        $criteria->compare('date',$this->date,true);
        $criteria->compare('comment',$this->comment,true);
        $criteria->compare('attendance',$this->attendance);
        $criteria->compare('weather',$this->weather,true);
        $criteria->compare('temperature',$this->temperature,true);
        $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
        $criteria->compare('Teams_idteam_home',$this->Teams_idteam_home);
        $criteria->compare('League_idleague_visiting',$this->League_idleague_visiting);
        $criteria->compare('League_idleague_home',$this->League_idleague_home);

        } else if (Yii::app()->session['role'] == 'roster') {

            $teamid = Yii::app()->session['team'];

            $criteria->compare('idgame',$this->idgame);
            $criteria->compare('location',$this->location,true);
            $criteria->compare('season',$this->season,true); 
            $criteria->compare('date',$this->date,true);
            $criteria->compare('comment',$this->comment,true);
            $criteria->compare('attendance',$this->attendance);
            $criteria->compare('weather',$this->weather,true);
            $criteria->compare('temperature',$this->temperature,true);
            $criteria->compare('Teams_idteam_visiting',$this->Teams_idteam_visiting);
            $criteria->compare('Teams_idteam_home',$teamid);
            $criteria->compare('League_idleague_visiting',$this->League_idleague_visiting);
            $criteria->compare('League_idleague_home',$this->League_idleague_home);
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
            $criteria->compare('League_idleague_visiting',$this->League_idleague_visiting);
            $criteria->compare('League_idleague_home',$this->League_idleague_home);
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
        $criteria->compare('League_idleague_visiting',$this->League_idleague_visiting);
        $criteria->compare('League_idleague_home',$this->League_idleague_home);

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
            $criteria->compare('League_idleague_visiting',$this->League_idleague_visiting);
            $criteria->compare('League_idleague_home',$this->League_idleague_home);
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
            $criteria->compare('League_idleague_visiting',$this->League_idleague_visiting);
            $criteria->compare('League_idleague_home',$this->League_idleague_home);
        }

        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}