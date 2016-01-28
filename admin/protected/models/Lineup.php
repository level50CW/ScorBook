<?php

/**
 * This is the model class for table "Lineup".
 *
 * The followings are the available columns in table 'Lineup':
 * @property integer $idlineup
 * @property integer $Inning
 * @property integer $Games_idgame
 *
 * The followings are the available model relations:
 * @property Batters[] $batters
 * @property Games $gamesIdgame
 */
class Lineup extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lineup the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lineup';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Games_idgame', 'required'),
            array('idlineup, Games_idgame, Teams_idteam', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idlineup, Inning, Games_idgame', 'safe', 'on' => 'search'),
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
            'batters' => array(self::HAS_MANY, 'Batters', 'Lineup_idlineup'),
            'gamesIdgame' => array(self::BELONGS_TO, 'Games', 'Games_idgame'),
            'teamsIdteam' => array(self::BELONGS_TO, 'Teams', 'Teams_idteam'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idlineup' => 'Idlineup',
            'Games_idgame' => 'Games Idgame',
            'Teams_idteam' => 'Teams Idteam'
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

        $criteria = new CDbCriteria;

        $criteria->compare('idlineup', $this->idlineup);
        $criteria->compare('Inning', $this->Inning);
        $criteria->compare('Games_idgame', $this->Games_idgame);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
	
	public function getByCondition($condition)
	{
		$criteria = new CDbCriteria();
		$criteria->addcondition($condition);
		
		$lineup = new Lineup;
		$lineup = Lineup::model()->findAll($criteria);
		return $lineup;
	}
	
	
	public function getByGameTeam($gameid, $idteam)
	{
		return Lineup::getByCondition("Games_idgame=".$gameid." AND Teams_idteam=".$idteam);
	}
	
	public function getById($idLineup)
	{
		return Lineup::getByCondition("idlineup=".$idLineup);
	}
}