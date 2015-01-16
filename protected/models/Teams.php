<?php

/**
 * This is the model class for table "Teams".
 *
 * The followings are the available columns in table 'Teams':
 * @property integer $idteam
 * @property string $Name
 * @property integer $League_idleague
 *
 * The followings are the available model relations:
 * @property Games[] $games
 * @property Games[] $games1
 * @property Players[] $players
 * @property League $leagueIdleague
 */
class Teams extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Teams the static model class
     */

    public $league;
    public $uploadfile;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Teams';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('League_idleague', 'required'),
            array('uploadfile', 'file', 'types'=>'jpg, jpeg, gif, png','safe'=>true, 'maxSize'=>30*1024*1024, 'allowEmpty'=>true, 'tooLarge'=>'{attribute} is too large to be uploaded. Maximum size is 30MB.'),
            array('idteam, League_idleague', 'numerical', 'integerOnly'=>true),
            array('Name', 'length', 'max'=>100),
            array('location', 'length', 'max'=>100),
            array('Abv', 'length', 'max'=>5),
            array('RGB', 'length', 'max'=>7),
            array('logo', 'length', 'max'=>150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idteam, Name, League_idleague, league, location', 'safe', 'on'=>'search'),
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
            'games' => array(self::HAS_MANY, 'Games', 'Teams_idteam_visiting'),
            'games1' => array(self::HAS_MANY, 'Games', 'Teams_idteam_home'),
            'players' => array(self::HAS_MANY, 'Players', 'Teams_idteam'),
            'leagueIdleague' => array(self::BELONGS_TO, 'League', 'League_idleague'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idteam' => 'Idteam',
            'Name' => 'Team Name',
            'location' => 'Stadium',
            'League_idleague' => 'League Idleague',
            'uploadfile' => 'uploadfile',
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
        $criteria->with = array('leagueIdleague');
        $criteria->compare('idteam',$this->idteam);
        $criteria->compare('t.Name',$this->Name,true);
        $criteria->order= 't.Name ASC';

        if ( isset ( $_GET['League'] )) {
            $criteria->compare('leagueIdleague.Name',$_GET['League']['Name'], true);
        }
        $criteria->order= 'leagueIdleague.Name ASC, t.Name ASC';
        echo Yii::trace(CVarDumper::dumpAsString($this->league['Name']),'idlineup');


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
