<?php

/**
 * This is the model class for table "Players".
 *
 * The followings are the available columns in table 'Players':
 * @property integer $idplayer
 * @property string $Firstname
 * @property string $Lastname
 * @property integer $Number
 * @property integer $Teams_idteam
 * @property string $Position
 * @property integer $Bats
 * @property integer $Throws
 *
 * The followings are the available model relations:
 * @property Batters[] $batters
 * @property Teams $teamsIdteam
 */
class Players extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Players the static model class
     */

    public $uploadfile;
    public $teamname;
    public $foot;
    public $inches;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Players';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Teams_idteam, Firstname, Lastname,status,Weight,Height, Number, Position, Bats, Throws, foot, inches, College,', 'required'),
            array('idplayer, Number, Teams_idteam', 'numerical', 'integerOnly' => true),
            array('uploadfile', 'file', 'types' => 'jpg, jpeg, gif, png', 'maxSize' => 30 * 1024 * 1024, 'allowEmpty' => true, 'tooLarge' => '{attribute} is too large to be uploaded. Maximum size is 30MB.'),
            array('Firstname, Lastname', 'length', 'max' => 50),
            array('Bats, Throws', 'length', 'max' => 2),
            array('Height','length', 'max' => 5),
            array('Weight','length', 'max' => 5),
            array('Position', 'length', 'max' => 2),
            array('Birthdate', 'safe'),
            array('Hometown, State, College, Class', 'length', 'max' => 50),
            array('Biography', 'length', 'max' => 500),
            array('status', 'length', 'max' => 2),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idplayer, Firstname, Lastname, Number, Teams_idteam, Position, Bats, Throws, teamname, foot, inches', 'safe', 'on' => 'search'),
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
            'batters' => array(self::HAS_MANY, 'Batters', 'Players_idplayer'),
            'teamsIdteam' => array(self::BELONGS_TO, 'Teams', 'Teams_idteam'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idplayer' => 'Idplayer',
            'Firstname' => 'First Name',
            'Lastname' => 'Last Name',
            'Number' => 'Number',
            'Teams_idteam' => 'Team Name',
            'teamname'=> 'Team Name',
            'Position' => 'Position',
            'Bats' => 'Bats',
            'Throws' => 'Throws',
            'status' => 'status'
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

        $criteria = new CDbCriteria;

        if (Yii::app()->session['role'] == 'admins') {
            $criteria->with = array('teamsIdteam');
            $criteria->order= 'teamsIdteam.Name ASC';
            $criteria->compare('teamsIdteam.Name', $this->teamname, true);
            $criteria->compare('idplayer', $this->idplayer);
            $criteria->compare('Firstname', $this->Firstname, true);
            $criteria->compare('Lastname', $this->Lastname, true);
            $criteria->compare('Number', $this->Number);
            //$criteria->compare('Teams_idteam',$this->Teams_idteam);
            $criteria->compare('Position', $this->Position, true);
            $criteria->compare('Bats', $this->Bats);
            $criteria->compare('Throws', $this->Throws);

        } else if (Yii::app()->session['role'] == 'roster') {
            $teamid = Yii::app()->session['team'];
            $criteria->with = 'teamsIdteam';
            $criteria->order= 'teamsIdteam.Name ASC';
            $criteria->compare('Teams_idteam',$teamid);
            $criteria->compare('teamsIdteam.Name', $this->teamname, true);
            $criteria->compare('idplayer', $this->idplayer);
            $criteria->compare('Firstname', $this->Firstname, true);
            $criteria->compare('Lastname', $this->Lastname, true);
            $criteria->compare('Number', $this->Number);
            //$criteria->compare('Teams_idteam',$this->Teams_idteam);
            $criteria->compare('Position', $this->Position, true);
            $criteria->compare('Bats', $this->Bats);
            $criteria->compare('Throws', $this->Throws);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}