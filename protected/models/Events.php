<?php

/**
 * This is the model class for table "Events".
 *
 * The followings are the available columns in table 'Events':
 * @property integer $idevents
 * @property string $Comment
 * @property integer $Lineup_idlineup
 * @property integer $Events_type_idevents_type
 * @property integer $Inning
 *
 * The followings are the available model relations:
 * @property Lineup $lineupIdlineup
 * @property EventsType $eventsTypeIdeventsType
 */
class Events extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	 public $maxatbat;
	 public $maxinning;
	 public $numberOuts;
	 public $maxbatter;
	 public $maxturntobat;
	 public $maxplay;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('idevents, Lineup_idlineup, Events_type_idevents_type', 'required'),
			array('idevents, Lineup_idlineup, Events_type_idevents_type, Inning, Batter, turntobat, b1, b2, b3', 'numerical', 'integerOnly'=>true),
			array('Comment, Misce', 'length', 'max'=>150),
			array('RBI, ER', 'length', 'max'=>10),
			array('text, OutText', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idevents, Comment, Lineup_idlineup, Events_type_idevents_type, Inning', 'safe', 'on'=>'search'),
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
			'lineupIdlineup' => array(self::BELONGS_TO, 'Lineup', 'Lineup_idlineup'),
			'eventsTypeIdeventsType' => array(self::BELONGS_TO, 'EventsType', 'Events_type_idevents_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idevents' => 'Idevents',
			'Comment' => 'Comment',
			'Lineup_idlineup' => 'Lineup Idlineup',
			'Events_type_idevents_type' => 'Events Type Idevents Type',
			'Inning' => 'Inning',
			'Batter' => 'Batter',
			'Misce' => 'Misce',
			'turntobat' => 'turntobat',
			'text' => 'text',
			'RBI' => 'RBI',
			'ER' => 'ER',
			'b1' => 'b1',
			'b2' => 'b2',
			'b3' => 'b3',
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

		$criteria->compare('idevents',$this->idevents);
		$criteria->compare('Comment',$this->Comment,true);
		$criteria->compare('Lineup_idlineup',$this->Lineup_idlineup);
		$criteria->compare('Events_type_idevents_type',$this->Events_type_idevents_type);
		$criteria->compare('Inning',$this->Inning);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}