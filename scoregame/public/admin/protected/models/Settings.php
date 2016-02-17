<?php

class Settings extends CActiveRecord
{	
	public $leagueName;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'settings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('iduser, idleague, listSize, idseason, leagueName, numberUmps', 'required'),
            array('iduser, idleague, idseason, listSize, numberUmps', 'numerical', 'integerOnly'=>true),
			array('iduser,', 'safe', 'on'=>'search'),
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
            'useriduser' => array(self::BELONGS_TO, 'Users', 'iduser'),
            'leagueidleague' => array(self::BELONGS_TO, 'Leadue', 'idleague'),
            'seasonidseason' => array(self::BELONGS_TO, 'Season', 'idseason'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idleague' => 'Leadue ID',
            'seasonidleague' => 'Season',
            'idseason' => 'Season ID',
            'monthStart' => 'Season Start Month',
            'monthEnd' => 'Season End Month',
            'listSize' => 'Max List Size',
            'numberUmps' => 'Number of Umps'
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
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	
	public static function get()
	{
		$model=Settings::model()->findByAttributes(array('iduser'=>Users::model()->find()->iduser));
		if($model==null){
			$model = new Settings;
			$model->iduser = Yii::app()->user->id;
			$model->idleague = League::model()->find()->idleague;
			$model->idseason = Season::model()->find('status=1')->idseason;
			$model->listSize = 25;
            $model->numberUmps = 3;
			$model->save();
			
		}
		$model->leagueName = League::model()->findByPk($model->idleague)->Name;
		return $model;
	}
}
