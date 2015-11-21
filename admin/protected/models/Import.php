<?php

class Import extends CFormModel
{
	public $scheduleData;
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
			array('scheduleData', 'required'),
			// array('qqqWWW', 'file', 'types'=>'csv','safe'=>true, 
				// 'maxSize'=>10*1024*1024, 
				// 'tooLarge'=>'{attribute} is too large to be uploaded. Maximum size is 10MB.', 'message' => 'File is not selected or has invalid type.',
				// ),
			array('fileImported', 'boolean', 'trueValue'=>true, 'message' => 'Invalid file format.')
        );
    }

    public function attributeLabels()
    {
        return array(
			'scheduleData' => 'Import Schedule',
        );
    }
}
