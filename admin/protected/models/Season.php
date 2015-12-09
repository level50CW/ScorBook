<?php

/**
 * This is the model class for table "season".
 *
 * The followings are the available columns in table 'league':
 * @property integer $idseason	
 * @property string $season
 * @property string $startdate
 * @property string $enddate
 *
 * The followings are the available model relations:
 * @property Division[] $divisions
 */
class Season extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'season';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('season,startdate,enddate,status', 'required'),
			array('idseason, season, status', 'numerical', 'integerOnly'=>true),
			array('season', 'unique', 'attributeName' => 'season',
					'message'=>'This Season is already created'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idseason, season, startdate, enddate', 'safe', 'on'=>'search'),
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
			'teams' => array(self::HAS_MANY, 'Teams', 'season_idseason'),
			'players' => array(self::HAS_MANY, 'Players', 'season_idseason'),
			'games' => array(self::HAS_MANY, 'Games', 'season_idseason'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'season' => 'Season',
			'startdate' => 'Start Date',
			'enddate' => 'End Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idseason',$this->idseason);
		$criteria->compare('season',$this->season,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->order = 'season DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function afterFind()
    {
        // convert to display format
        $this->startdate = Games::model()->dateToAmericanFormat($this->startdate,false);
        $this->enddate = Games::model()->dateToAmericanFormat($this->enddate,false);
        parent::afterFind();
    }
	
	protected function beforeValidate()
    {
        // convert to storage format
        // Not used yet as validation for date is not set in current implementation
		$this->startdate = Games::model()->dateFromAmericanFormat($this->startdate,false);
        $this->enddate = Games::model()->dateFromAmericanFormat($this->enddate,false);
        return parent::beforeValidate();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return League the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
