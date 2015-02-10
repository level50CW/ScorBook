<?php

/**
 * This is the model class for table "statsfielding".
 *
 * The followings are the available columns in table 'statsfielding':
 * @property integer $Idstatsfield
 * @property integer $Players_idplayer
 * @property integer $Games_idgames
 * @property integer $G
 * @property integer $GS
 * @property integer $INN
 * @property integer $TC
 * @property integer $PO
 * @property integer $A
 * @property integer $E
 * @property integer $DP
 * @property integer $SB
 * @property integer $CS
 * @property double $SBPCT
 * @property integer $PB
 * @property integer $C_WP
 * @property double $FPCT
 * @property double $RF
 */
class Statsfielding extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Statsfielding the static model class
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
		return 'statsfielding';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Players_idplayer, Games_idgame, G, GS, INN, TC, PO, A, E, DP, SB, CS, PB, C_WP', 'numerical', 'integerOnly'=>true),
			array('SBPCT, FPCT, RF', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Idstatsfield, Players_idplayer, Games_idgame, G, GS, INN, TC, PO, A, E, DP, SB, CS, SBPCT, PB, C_WP, FPCT, RF', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Idstatsfield' => 'Idstatsfield',
			'Players_idplayer' => 'Players Idplayer',
			'Games_idgame' => 'Games Idgame',
			'G' => 'G',
			'GS' => 'Gs',
			'INN' => 'Inn',
			'TC' => 'Tc',
			'PO' => 'Po',
			'A' => 'A',
			'E' => 'E',
			'DP' => 'Dp',
			'SB' => 'Sb',
			'CS' => 'Cs',
			'SBPCT' => 'Sbpct',
			'PB' => 'Pb',
			'C_WP' => 'C Wp',
			'FPCT' => 'Fpct',
			'RF' => 'Rf',
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

		$criteria->compare('Idstatsfield',$this->Idstatsfield);
		$criteria->compare('Players_idplayer',$this->Players_idplayer);
		$criteria->compare('Games_idgame',$this->Games_idgame);
		$criteria->compare('G',$this->G);
		$criteria->compare('GS',$this->GS);
		$criteria->compare('INN',$this->INN);
		$criteria->compare('TC',$this->TC);
		$criteria->compare('PO',$this->PO);
		$criteria->compare('A',$this->A);
		$criteria->compare('E',$this->E);
		$criteria->compare('DP',$this->DP);
		$criteria->compare('SB',$this->SB);
		$criteria->compare('CS',$this->CS);
		$criteria->compare('SBPCT',$this->SBPCT);
		$criteria->compare('PB',$this->PB);
		$criteria->compare('C_WP',$this->C_WP);
		$criteria->compare('FPCT',$this->FPCT);
		$criteria->compare('RF',$this->RF);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getByGame($idgame)
	{
		$criteria = new CDbCriteria();
		$criteria->addcondition("Games_idgame=".$idgame);
		$statsfielding = Statsfielding::model()->findAll($criteria);
		return $statsfielding;
	}
}