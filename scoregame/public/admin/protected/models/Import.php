<?php

class Import extends CFormModel
{
	public $data;
	public $fileImported;
	public $importedRowsCount;
	
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
			array('data', 'required'),
			array('fileImported', 'boolean', 'trueValue'=>true, 'message' => 'Invalid file format.')
        );
    }

    public function attributeLabels()
    {
        return array(
			'data' => 'Import data',
        );
    }
}
