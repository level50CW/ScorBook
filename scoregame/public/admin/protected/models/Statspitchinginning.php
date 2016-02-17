<?php

/**
 * This is the model class for table "statspitching".
 *
 * The followings are the available columns in table 'statspitching':
 * @property integer $idstatspit
 * @property integer $Players_idplayer
 * @property integer $Games_idgame
 * @property integer $W
 * @property integer $L
 * @property double $ERA
 * @property integer $G
 * @property integer $GS
 * @property integer $SV
 * @property integer $SVO
 * @property integer $IP
 * @property integer $H
 * @property integer $R
 * @property integer $ER
 * @property integer $HR
 * @property integer $BB
 * @property integer $SO
 * @property double $AVG
 * @property double $WHIP
 * @property integer $CG
 * @property integer $SHO
 * @property integer $HB
 * @property integer $IBB
 * @property integer $GF
 * @property integer $HLD
 * @property integer $GIDP
 * @property integer $GO
 * @property integer $AO
 * @property integer $WP
 * @property integer $BK
 * @property integer $SB
 * @property integer $CS
 * @property integer $PK
 * @property integer $TBF
 * @property integer $NP
 * @property integer $WPCT
 * @property integer $GO_AO
 * @property double $OBP
 * @property double $SLG
 * @property double $OPS
 * @property double $K_9
 * @property double $BB_9
 * @property double $K_BB
 * @property double $P_IP
 *
 * The followings are the available model relations:
 * @property Games $gamesIdgame
 * @property Players $playersIdplayer
 */
class Statspitchinginning extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Statspitching the static model class
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
        return 'statspitching_inning';
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
            array('Players_idplayer, Games_idgame, Lineup_idlineup, Inning,  W, L, G, GS, SV, SVO, H, R, ER, HR, BB, SO, CG, SHO, HB, IBB, GF, HLD, GIDP, GO, AO, WP, BK, SB, CS, PK, TBF, NP, WPCT, GO_AO, AB', 'numerical', 'integerOnly'=>true),
            array('ERA, AVG, WHIP, OBP, SLG, OPS, K_9, BB_9, K_BB, P_IP', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idstatspit, Players_idplayer, Games_idgame, Lineup_idlineup, Inning, W, L, ERA, G, GS, SV, SVO, IP, H, R, ER, HR, BB, SO, AVG, WHIP, CG, SHO, HB, IBB, GF, HLD, GIDP, GO, AO, WP, BK, SB, CS, PK, TBF, NP, WPCT, GO_AO, OBP, SLG, OPS, K_9, BB_9, K_BB, P_IP', 'safe', 'on'=>'search'),
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
            'lineupIdlineup' => array(self::BELONGS_TO, 'Lineup', 'Lineup_idlineup'),
            'playersIdplayer' => array(self::BELONGS_TO, 'Players', 'Players_idplayer'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idstatspit' => 'Idstatspit',
            'Players_idplayer' => 'Players Idplayer',
            'Games_idgame' => 'Games Idgame',
            'Lineup_idlineup' => 'Lineup Idlineup',
            'Inning' => 'Inning',
            'W' => 'W',
            'L' => 'L',
            'ERA' => 'Era',
            'G' => 'G',
            'GS' => 'Gs',
            'SV' => 'Sv',
            'SVO' => 'Svo',
            'IP' => 'Ip',
            'H' => 'H',
            'R' => 'R',
            'ER' => 'Er',
            'HR' => 'Hr',
            'BB' => 'Bb',
            'SO' => 'So',
            'AVG' => 'Avg',
            'WHIP' => 'Whip',
            'CG' => 'Cg',
            'SHO' => 'Sho',
            'HB' => 'Hb',
            'IBB' => 'Ibb',
            'GF' => 'Gf',
            'HLD' => 'Hld',
            'GIDP' => 'Gidp',
            'GO' => 'Go',
            'AO' => 'Ao',
            'WP' => 'Wp',
            'BK' => 'Bk',
            'SB' => 'Sb',
            'CS' => 'Cs',
            'PK' => 'Pk',
            'TBF' => 'Tbf',
            'NP' => 'Np',
            'WPCT' => 'Wpct',
            'GO_AO' => 'Go Ao',
            'OBP' => 'Obp',
            'SLG' => 'Slg',
            'OPS' => 'Ops',
            'K_9' => 'K 9',
            'BB_9' => 'Bb 9',
            'K_BB' => 'K Bb',
            'P_IP' => 'P Ip',
            'AB' => 'AB'
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

        $criteria->compare('idstatspit',$this->idstatspit);
        $criteria->compare('Players_idplayer',$this->Players_idplayer);
        $criteria->compare('Games_idgame',$this->Games_idgame);
        $criteria->compare('Lineup_idlineup',$this->Lineup_idlineup);
        $criteria->compare('Inning',$this->Inning);
        $criteria->compare('W',$this->W);
        $criteria->compare('L',$this->L);
        $criteria->compare('ERA',$this->ERA);
        $criteria->compare('G',$this->G);
        $criteria->compare('GS',$this->GS);
        $criteria->compare('SV',$this->SV);
        $criteria->compare('SVO',$this->SVO);
        $criteria->compare('IP',$this->IP);
        $criteria->compare('H',$this->H);
        $criteria->compare('R',$this->R);
        $criteria->compare('ER',$this->ER);
        $criteria->compare('HR',$this->HR);
        $criteria->compare('BB',$this->BB);
        $criteria->compare('SO',$this->SO);
        $criteria->compare('AVG',$this->AVG);
        $criteria->compare('WHIP',$this->WHIP);
        $criteria->compare('CG',$this->CG);
        $criteria->compare('SHO',$this->SHO);
        $criteria->compare('HB',$this->HB);
        $criteria->compare('IBB',$this->IBB);
        $criteria->compare('GF',$this->GF);
        $criteria->compare('HLD',$this->HLD);
        $criteria->compare('GIDP',$this->GIDP);
        $criteria->compare('GO',$this->GO);
        $criteria->compare('AO',$this->AO);
        $criteria->compare('WP',$this->WP);
        $criteria->compare('BK',$this->BK);
        $criteria->compare('SB',$this->SB);
        $criteria->compare('CS',$this->CS);
        $criteria->compare('PK',$this->PK);
        $criteria->compare('TBF',$this->TBF);
        $criteria->compare('NP',$this->NP);
        $criteria->compare('WPCT',$this->WPCT);
        $criteria->compare('GO_AO',$this->GO_AO);
        $criteria->compare('OBP',$this->OBP);
        $criteria->compare('SLG',$this->SLG);
        $criteria->compare('OPS',$this->OPS);
        $criteria->compare('K_9',$this->K_9);
        $criteria->compare('BB_9',$this->BB_9);
        $criteria->compare('K_BB',$this->K_BB);
        $criteria->compare('P_IP',$this->P_IP);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}