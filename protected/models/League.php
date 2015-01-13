<?php

/**
 * This is the model class for table "League".
 *
 * The followings are the available columns in table 'League':
 * @property integer $idleague
 * @property string $Name
 *
 * The followings are the available model relations:
 * @property Games[] $games
 * @property Games[] $games1
 * @property Teams[] $teams
 */
class League extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return League the static model class
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
		return 'League';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idleague', 'numerical', 'integerOnly'=>true),
			array('Name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idleague, Name, type', 'safe', 'on'=>'search'),
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
			'games' => array(self::HAS_MANY, 'Games', 'League_idleague_visiting'),
			'games1' => array(self::HAS_MANY, 'Games', 'League_idleague_home'),
			'teams' => array(self::HAS_MANY, 'Teams', 'League_idleague'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idleague' => 'Idleague',
			'Name' => 'Name',
			'type' => 'Type'
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

		$criteria->compare('idleague',$this->idleague);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('type','division',true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}