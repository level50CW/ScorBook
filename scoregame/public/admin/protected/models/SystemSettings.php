<?php

class SystemSettings extends CFormModel
{
	public $databaseUrl;
	public $databaseUsername;
	public $databasePassword;
	public $databaseConfirm;
	public $databasePasswordChanged;
	public $adminPassword;
	
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
        );
    }
}
