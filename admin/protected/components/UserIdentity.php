<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
    public function authenticate()
    {
        //$record=ZbUsers::model()->findByAttributes(array('email'=>$this->username));
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("email=:username");
		$criteria->params = array(':username'=>$this->username);
		
		
		$record=Users::model()->findAll($criteria);
		$record=$record[0];
        //$record=ZbUsers::model()->findByAttributes(array('email'=>$this->username));
		
		//echo Yii::trace(CVarDumper::dumpAsString($record->email),'VarError1');
		//echo Yii::trace(CVarDumper::dumpAsString($record1->username),'VarError1');
		
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->Password!==md5($this->password)){
        	
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
        }else
        {
        	
            $this->_id=$record->iduser;
            //s$this->setState('title', $record->title);
            $this->username=$record->Email;
	        $auth=Yii::app()->authManager;
			
			$assigned_roles = Yii::app()->authManager->getRoles(Yii::app()->user->id); 
			
			
			
			
			if(!empty($assigned_roles)) //checks that there are assigned roles
		    {
		        $auth=Yii::app()->authManager; //initializes the authManager
		        foreach($assigned_roles as $n=>$role)
		        {
		            if($auth->revoke($n,Yii::app()->user->id)) //remove each assigned role for this user
		                Yii::app()->authManager->save(); //again always save the result
		        }
		    }
			echo Yii::trace(Yii::app()->user->id,'VarError1');
			
	        if(!$auth->isAssigned($record->role,$this->_id))
	        {
	        	
	        	
			    if($auth->assign($record->role,$this->_id))
	            {
	            		
	                Yii::app()->authManager->save();
					
					
	            }
	        }
            $this->errorCode=self::ERROR_NONE;
			
        }
        return !$this->errorCode;
    }

	public function getId()
    {
        return $this->_id;
    }
}