<?php

/**
 * This is the model class for table "Teams".
 *
 * The followings are the available columns in table 'Teams':
 * @property integer $idteam
 * @property string $Name
 * @property integer $Division_iddivision
 *
 * The followings are the available model relations:
 * @property Games[] $games
 * @property Games[] $games1
 * @property Players[] $players
 * @property Division $divisionIddivision
 */
class Teams extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Teams the static model class
     */

	public $leagueIdleague_Name;
	public $division_Season;
	public $division_Name;
    public $division;
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
            array('Division_iddivision, Name, Abv, location', 'required'),
            array('uploadfile', 'file', 'types'=>'jpg, jpeg, gif, png','safe'=>true, 
				'maxSize'=>30*1024*1024, 
				'allowEmpty'=>true, 
				'tooLarge'=>'{attribute} is too large to be uploaded. Maximum size is 30MB.'),
            array('idteam, Division_iddivision', 'numerical', 'integerOnly'=>true),
            array('Name', 'length', 'max'=>100),
            array('location', 'length', 'max'=>100),
            array('Abv', 'length', 'max'=>5),
            array('RGB', 'length', 'max'=>7),
            array('logo', 'length', 'max'=>150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idteam, Name, Division_iddivision, division, location, Abv, divisionIddivision.league_idleague, leagueIdleague_Name, division_Season, division_Name', 'safe', 'on'=>'search'),
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
            'divisionIddivision' => array(self::BELONGS_TO, 'Division', 'Division_iddivision'),
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
            'Division_iddivision' => 'Division Iddivision',
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
        $criteria->with = array('divisionIddivision');
        $criteria->compare('idteam',$this->idteam);
        $criteria->compare('t.Name',$this->Name,true);
        $criteria->order= 't.Name ASC';

        if ( isset ( $_GET['Division'] )) {
            $criteria->compare('divisionIddivision.Name',$_GET['Division']['Name'], true);
        }
        $criteria->order= 'divisionIddivision.Name ASC, t.Name ASC';
        echo Yii::trace(CVarDumper::dumpAsString($this->division['Name']),'idlineup');
		
		$criteria->compare('divisionIddivision.league_idleague', isset($this->leagueIdleague_Name) && $this->leagueIdleague_Name>-1? $this->leagueIdleague_Name : null);
		$criteria->compare('divisionIddivision.iddivision', $this->division_Name);
		
		
		//if (!isset($this->division_Season))	$this->division_Season = date('Y');
		
		if (isset($this->division_Season) && $this->division_Season)
			$criteria->addCondition("$this->division_Season IN (SELECT `season` 
									FROM  `games` 
									WHERE  `Division_iddivision_home` =t.`Division_iddivision`
									OR  `Division_iddivision_visiting` =t.`Division_iddivision`)");
		
		$criteria->compare('Abv', $this->Abv);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	
	public function next()
	{
		$nextModel = $this->find('idteam>:id ORDER BY idteam', array(':id'=>$this->idteam));
		if (count($nextModel) == 0)
			$nextModel = $this->find(' 1 ORDER BY idteam');
		return $nextModel;
	}
}
