<?php

/**
 * This is the model class for table "Batters".
 *
 * The followings are the available columns in table 'Batters':
 * @property integer $idbatter
 * @property string $Position
 * @property integer $Players_idplayer
 * @property integer $Number
 * @property string $Batterscol
 * @property integer $Lineup_idlineup
 *
 * The followings are the available model relations:
 * @property Players $playersIdplayer
 * @property Lineup $lineupIdlineup
 * @property Inning $Inning
 */
class Batters extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Batters the static model class
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
		return 'Batters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Players_idplayer, Lineup_idlineup', 'required'),
			array('idbatter, Players_idplayer, Number, Lineup_idlineup, Inning, BatterPosition', 'numerical', 'integerOnly'=>true),
			array('DefensePosition', 'length', 'max'=>2),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idbatter, Position, Players_idplayer, Number, Lineup_idlineup', 'safe', 'on'=>'search'),
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
			'playersIdplayer' => array(self::BELONGS_TO, 'Players', 'Players_idplayer'),
			'lineupIdlineup' => array(self::BELONGS_TO, 'Lineup', 'Lineup_idlineup'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idbatter' => 'Idbatter',
			'DefensePosition' => 'Defense Position',
			'BatterPosition' => 'Batter Position',
			'Players_idplayer' => 'Players Idplayer',
			'Number' => 'Number',
			'Lineup_idlineup' => 'Lineup Idlineup',
			'Inning' =>'Inning',
			
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

		$criteria->compare('idbatter',$this->idbatter);
		$criteria->compare('Position',$this->Position,true);
		$criteria->compare('Players_idplayer',$this->Players_idplayer);
		$criteria->compare('Number',$this->Number);
		$criteria->compare('Lineup_idlineup',$this->Lineup_idlineup);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getCountInLineup($idlineup)
	{
		$criteria = new CDbCriteria();
		$criteria->addcondition("Lineup_idlineup = " . (string)(int)$idlineup);
		$Batters = Batters::model()->findAll($criteria);
		
		return sizeof($Batters);
	}
}