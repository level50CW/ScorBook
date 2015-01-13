<?php

/**
 * This is the model class for table "GameOfficials".
 *
 * The followings are the available columns in table 'GameOfficials':
 * @property integer $idGameOfficials
 * @property integer $Games_idgame
 * @property integer $Officials_idofficials
 * @property string $Position
 *
 * The followings are the available model relations:
 * @property Games $gamesIdgame
 * @property Officials $officialsIdofficials
 */
class GameOfficials extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GameOfficials the static model class
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
		return 'GameOfficials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idGameOfficials, Games_idgame, Officials_idofficials', 'required'),
			array('idGameOfficials, Games_idgame, Officials_idofficials', 'numerical', 'integerOnly'=>true),
			array('Position', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idGameOfficials, Games_idgame, Officials_idofficials, Position', 'safe', 'on'=>'search'),
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
			'gamesIdgame' => array(self::BELONGS_TO, 'Games', 'Games_idgame'),
			'officialsIdofficials' => array(self::BELONGS_TO, 'Officials', 'Officials_idofficials'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idGameOfficials' => 'Id Game Officials',
			'Games_idgame' => 'Games Idgame',
			'Officials_idofficials' => 'Officials Idofficials',
			'Position' => 'Position',
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

		$criteria->compare('idGameOfficials',$this->idGameOfficials);
		$criteria->compare('Games_idgame',$this->Games_idgame);
		$criteria->compare('Officials_idofficials',$this->Officials_idofficials);
		$criteria->compare('Position',$this->Position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}