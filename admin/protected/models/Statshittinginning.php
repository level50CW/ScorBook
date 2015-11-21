<?php

/**
 * This is the model class for table "statshitting".
 *
 * The followings are the available columns in table 'statshitting':
 * @property integer $idstatshit
 * @property integer $Players_idplayer
 * @property integer $Games_idgame
 * @property integer $G
 * @property integer $AB
 * @property integer $R
 * @property integer $H
 * @property integer $v2B
 * @property integer $v3B
 * @property integer $HR
 * @property integer $RBI
 * @property integer $BB
 * @property integer $SO
 * @property integer $SB
 * @property integer $CS
 * @property double $AVG
 * @property double $OBP
 * @property double $SLG
 * @property double $OPS
 * @property integer $IBB
 * @property integer $HBP
 * @property integer $SAC
 * @property integer $SF
 * @property integer $TB
 * @property integer $XBH
 * @property integer $GDP
 * @property integer $GO
 * @property integer $AO
 * @property integer $GO_AO
 * @property integer $NP
 * @property integer $PA
 *
 * The followings are the available model relations:
 * @property Players $playersIdplayer
 * @property Games $gamesIdgame
 */
class Statshittinginning extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Statshitting the static model class
     */
    public $g_total;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'statshitting_inning';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Players_idplayer, Games_idgame', 'required'),
            array('Players_idplayer, Games_idgame, Lineup_idlineup, Inning, Events_idevent, G, AB, R, H, v2B, v3B, HR, RBI, BB, SO, SB, CS, IBB, HBP, SAC, SF, TB, XBH, GDP, GO, AO, GO_AO, NP, PA', 'numerical', 'integerOnly'=>true),
            array('AVG, OBP, SLG, OPS', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idstatshit, Players_idplayer, Games_idgame, Lineup_idlineup, Inning, Events_idevent, G, AB, R, H, v2B, v3B, HR, RBI, BB, SO, SB, CS, AVG, OBP, SLG, OPS, IBB, HBP, SAC, SF, TB, XBH, GDP, GO, AO, GO_AO, NP, PA', 'safe', 'on'=>'search'),
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
            'gamesIdgame' => array(self::BELONGS_TO, 'Games', 'Games_idgame'),
            'Events_idevent' => array(self::BELONGS_TO, 'Events', 'Events_idevent'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idstatshit' => 'Idstatshit',
            'Players_idplayer' => 'Players Idplayer',
            'Games_idgame' => 'Games Idgame',
            'Lineup_idlineup' => 'Lineup Idlineup',
            'Inning' => 'Inning',
            'Events_idevent' => 'Events idevent',
            'G' => 'G',
            'AB' => 'Ab',
            'R' => 'R',
            'H' => 'H',
            'v2B' => 'V2 B',
            'v3B' => 'V3 B',
            'HR' => 'Hr',
            'RBI' => 'Rbi',
            'BB' => 'Bb',
            'SO' => 'So',
            'SB' => 'Sb',
            'CS' => 'Cs',
            'AVG' => 'Avg',
            'OBP' => 'Obp',
            'SLG' => 'Slg',
            'OPS' => 'Ops',
            'IBB' => 'Ibb',
            'HBP' => 'Hbp',
            'SAC' => 'Sac',
            'SF' => 'Sf',
            'TB' => 'Tb',
            'XBH' => 'Xbh',
            'GDP' => 'Gdp',
            'GO' => 'Go',
            'AO' => 'Ao',
            'GO_AO' => 'Go Ao',
            'NP' => 'Np',
            'PA' => 'Pa',
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

        $criteria->compare('idstatshit',$this->idstatshit);
        $criteria->compare('Players_idplayer',$this->Players_idplayer);
        $criteria->compare('Games_idgame',$this->Games_idgame);
        $criteria->compare('Lineup_idlineup',$this->Lineup_idlineup);
        $criteria->compare('Inning',$this->Inning);
        $criteria->compare('Events_idevent',$this->Events_idevent);
        $criteria->compare('G',$this->G);
        $criteria->compare('AB',$this->AB);
        $criteria->compare('R',$this->R);
        $criteria->compare('H',$this->H);
        $criteria->compare('v2B',$this->v2B);
        $criteria->compare('v3B',$this->v3B);
        $criteria->compare('HR',$this->HR);
        $criteria->compare('RBI',$this->RBI);
        $criteria->compare('BB',$this->BB);
        $criteria->compare('SO',$this->SO);
        $criteria->compare('SB',$this->SB);
        $criteria->compare('CS',$this->CS);
        $criteria->compare('AVG',$this->AVG);
        $criteria->compare('OBP',$this->OBP);
        $criteria->compare('SLG',$this->SLG);
        $criteria->compare('OPS',$this->OPS);
        $criteria->compare('IBB',$this->IBB);
        $criteria->compare('HBP',$this->HBP);
        $criteria->compare('SAC',$this->SAC);
        $criteria->compare('SF',$this->SF);
        $criteria->compare('TB',$this->TB);
        $criteria->compare('XBH',$this->XBH);
        $criteria->compare('GDP',$this->GDP);
        $criteria->compare('GO',$this->GO);
        $criteria->compare('AO',$this->AO);
        $criteria->compare('GO_AO',$this->GO_AO);
        $criteria->compare('NP',$this->NP);
        $criteria->compare('PA',$this->PA);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}