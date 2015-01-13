<?php

/**
 * This is the model class for table "runs".
 *
 * The followings are the available columns in table 'runs':
 * @property integer $idrun
 * @property integer $teams_idteam
 * @property integer $inning1
 * @property integer $inning2
 * @property integer $inning3
 * @property integer $inning4
 * @property integer $inning5
 * @property integer $inning6
 * @property integer $inning7
 * @property integer $inning8
 * @property integer $inning9
 * @property integer $R
 * @property integer $H
 * @property integer $E
 * @property integer $games_idgame
 *
 * The followings are the available model relations:
 * @property Games $gamesIdgame
 * @property Teams $teamsIdteam
 */
class Runs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Runs the static model class
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
		return 'runs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teams_idteam, inning1, inning2, inning3, inning4, inning5, inning6, inning7, inning8, inning9, R, H, E, games_idgame', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idrun, teams_idteam, inning1, inning2, inning3, inning4, inning5, inning6, inning7, inning8, inning9, R, H, E, games_idgame', 'safe', 'on'=>'search'),
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
			'gamesIdgame' => array(self::BELONGS_TO, 'Games', 'games_idgame'),
			'teamsIdteam' => array(self::BELONGS_TO, 'Teams', 'teams_idteam'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idrun' => 'Idrun',
			'teams_idteam' => 'Teams Idteam',
			'inning1' => 'Inning1',
			'inning2' => 'Inning2',
			'inning3' => 'Inning3',
			'inning4' => 'Inning4',
			'inning5' => 'Inning5',
			'inning6' => 'Inning6',
			'inning7' => 'Inning7',
			'inning8' => 'Inning8',
			'inning9' => 'Inning9',
			'R' => 'R',
			'H' => 'H',
			'E' => 'E',
			'games_idgame' => 'Games Idgame',
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

		$criteria->compare('idrun',$this->idrun);
		$criteria->compare('teams_idteam',$this->teams_idteam);
		$criteria->compare('inning1',$this->inning1);
		$criteria->compare('inning2',$this->inning2);
		$criteria->compare('inning3',$this->inning3);
		$criteria->compare('inning4',$this->inning4);
		$criteria->compare('inning5',$this->inning5);
		$criteria->compare('inning6',$this->inning6);
		$criteria->compare('inning7',$this->inning7);
		$criteria->compare('inning8',$this->inning8);
		$criteria->compare('inning9',$this->inning9);
		$criteria->compare('R',$this->R);
		$criteria->compare('H',$this->H);
		$criteria->compare('E',$this->E);
		$criteria->compare('games_idgame',$this->games_idgame);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}