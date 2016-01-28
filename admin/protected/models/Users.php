<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property integer $iduser
 * @property string $Firstname
 * @property string $Lastname
 * @property string $Email
 * @property string $Password
 * @property string $ConfirmPassword
 * @property string $role
 */
class Users extends CActiveRecord
{
	
	public $leagueIdleague_Name;
	public $division_Name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Firstname, Lastname, Email, Password, role, Teams_idteam','required'),
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('Firstname, Lastname', 'length', 'max'=>45),
			array('Email', 'length', 'max'=>150),
			array('Password', 'length', 'max'=>35),
			array('role', 'length', 'max'=>30),
			array('Teams_idteam', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iduser, Firstname, Lastname, Email, Password, role, leagueIdleague_Name, division_Name', 'safe', 'on'=>'search'),
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
            'teamsIdteam' => array(self::BELONGS_TO, 'Teams', 'Teams_idteam'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iduser' => 'Iduser',
			'Firstname' => 'First Name',
			'Lastname' => 'Last Name',
			'Email' => 'Email',
			'Password' => 'Password',
			'role' => 'Role',
			'Teams_idteam' => 'Team'
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

		$roles = array(
			'System Admin' => 'admins',
			'League Admin' => 'leagueadmin',
			'Team Admin' => 'teamadmin',
			'Team Roster Admin' => 'roster',
			'Scorekeeper' => 'scorer',
			'User' => 'user'
		);
		
		$criteria=new CDbCriteria;

		if (Yii::app()->session['role'] == 'admins' || Yii::app()->session['role'] == 'leagueadmin') {
			$criteria->compare('iduser',$this->iduser);
			$criteria->compare('Firstname',$this->Firstname,true);
			$criteria->compare('Lastname',$this->Lastname,true);
			$criteria->compare('Email',$this->Email,true);
			$criteria->compare('Password',$this->Password,true);
			
			if (isset($roles[$this->role]))
				$criteria->compare('role',$roles[$this->role],true);
			
			$criteria->order= 'Lastname ASC, Firstname ASC';
			
			$criteria->with = array('teamsIdteam.divisionIddivision');
			$criteria->compare('divisionIddivision.league_idleague', $this->leagueIdleague_Name);
			$criteria->compare('divisionIddivision.iddivision', $this->division_Name);
		} else if (Yii::app()->session['role'] == 'roster' || Yii::app()->session['role'] == 'teamadmin'){
			$teamid = Yii::app()->session['team'];
			$criteria->compare('iduser',$this->iduser);
			$criteria->compare('Teams_idteam',$teamid);
			$criteria->compare('Firstname',$this->Firstname,true);
			$criteria->compare('Lastname',$this->Lastname,true);
			$criteria->compare('Email',$this->Email,true);
			$criteria->compare('Password',$this->Password,true);
			$criteria->compare('role',$roles[$this->role],true);
			$criteria->order= 'Lastname ASC, Firstname ASC';
			
			$criteria->with = array('teamsIdteam.divisionIddivision');
			$criteria->compare('divisionIddivision.league_idleague', $this->leagueIdleague_Name);
			$criteria->compare('divisionIddivision.iddivision', $this->division_Name);
		}
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => Settings::get()->listSize
			)
		));
	}
	
	public function next()
	{
		$nextModel = $this->find('iduser>:id ORDER BY iduser', array(':id'=>$this->iduser));
		if (count($nextModel) == 0)
			$nextModel = $this->find(' 1 ORDER BY iduser');
		return $nextModel;
	}
}