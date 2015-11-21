<?php

/**
 * This is the model class for table "Officials".
 *
 * The followings are the available columns in table 'Officials':
 * @property integer $idofficials
 * @property string $Name
 * @property string $Lastname
 *
 * The followings are the available model relations:
 * @property GameOfficials[] $gameOfficials
 */
class Officials extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Officials the static model class
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
		return 'Officials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idofficials', 'required'),
			array('idofficials', 'numerical', 'integerOnly'=>true),
			array('Name, Lastname', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idofficials, Name, Lastname', 'safe', 'on'=>'search'),
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
			'gameOfficials' => array(self::HAS_MANY, 'GameOfficials', 'Officials_idofficials'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idofficials' => 'Idofficials',
			'Name' => 'Name',
			'Lastname' => 'Lastname',
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

		$criteria->compare('idofficials',$this->idofficials);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Lastname',$this->Lastname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}