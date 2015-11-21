<?php

class Settings extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Settings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('iduser, idleague, season, monthStart, monthEnd, listSize', 'required'),
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
            'useriduser' => array(self::HAS_ONE, 'Users', 'iduser'),
            'leagueidleague' => array(self::HAS_ONE, 'Leadue', 'idleague'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idleague' => 'Leadue ID',
            'season' => 'Season',
            'monthStart' => 'Season Start Month',
            'monthEnd' => 'Season End Month',
            'listSize' => 'Max List Size',
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
		$model=Settings::model()->findByAttributes(array('iduser'=>Users::model()->find()->iduser));//Yii::app()->user->id
		if($model==null){
			$model = new Settings;
			$model->iduser = Yii::app()->user->id;
			$model->idleague = League::model()->find()->idleague;
			$model->season = +date('Y');
			$model->monthStart = 1;
			$model->monthEnd = 2;
			$model->listSize = 25;
			$model->save();
			
			echo 'Qwer';
		}
		return $model;
	}
}
