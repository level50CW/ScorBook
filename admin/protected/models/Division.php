<?php

/**
 * This is the model class for table "Division".
 *
 * The followings are the available columns in table 'Division':
 * @property integer $iddivision
 * @property string $Name
 * @property integer $league_idleague
 *
 * The followings are the available model relations:
 * @property League $leagueIdleague
 * @property Games[] $games
 * @property Games[] $games1
 * @property Teams[] $teams
 */
class Division extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Division the static model class
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
		return 'division';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iddivision', 'numerical', 'integerOnly'=>true),
			array('league_idleague, Name', 'required'),
			array('league_idleague', 'numerical', 'integerOnly'=>true),
			array('Name', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iddivision, Name, league_idleague', 'safe', 'on'=>'search'),
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
			'leagueIdleague' => array(self::BELONGS_TO, 'League', 'league_idleague'),
			'games' => array(self::HAS_MANY, 'Games', 'Division_iddivision_visiting'),
			'games1' => array(self::HAS_MANY, 'Games', 'Division_iddivision_home'),
			'teams' => array(self::HAS_MANY, 'Teams', 'Division_iddivision'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iddivision' => 'Iddivision',
			'Name' => 'Division',
			'league_idleague' => 'League Idleague',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('iddivision',$this->iddivision);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('league_idleague',$this->league_idleague);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getSeason($data)
	{
		if (!isset($data))
			return 0;
		
		$id = $data->iddivision;
		$connection = Yii::app()->db;
		$command = $connection->createCommand("SELECT `season` 
												FROM  `games` 
												WHERE  `Division_iddivision_home` =$id
												OR  `Division_iddivision_visiting` =$id
												ORDER BY `season` DESC");
		$row = $command->queryAll();
		if (isset($row[0]))
			return $row[0]['season'];
		else
			return "--";
	}
}