<?php

/**
 * This is the model class for table "Events_type".
 *
 * The followings are the available columns in table 'Events_type':
 * @property integer $idevents_type
 * @property string $Name
 *
 * The followings are the available model relations:
 * @property Events[] $events
 */
class EventsType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EventsType the static model class
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
		return 'Events_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idevents_type', 'required'),
			array('idevents_type', 'numerical', 'integerOnly'=>true),
			array('Name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idevents_type, Name', 'safe', 'on'=>'search'),
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
			'events' => array(self::HAS_MANY, 'Events', 'Events_type_idevents_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idevents_type' => 'Idevents Type',
			'Name' => 'Name',
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

		$criteria->compare('idevents_type',$this->idevents_type);
		$criteria->compare('Name',$this->Name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}