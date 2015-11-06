<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public $emailaddress;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
	    $emailaddress = strtolower($this->emailaddress);
	    $user = User::model()->find(array(
	        'condition'=>'emailaddress=:emailaddress',
	        'params'=>array(':emailaddress'=>$emailaddress),
	    ));

		if(!isset($user))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($user->password!==md5($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{	 
		    //how to use these message   
		    $this->emailaddress = $user->emailaddress; 
		    Yii::app()->session['username'] = $user->username;
		    $this->_id = $user->id;
		    $this->setState('type', $user->accesstype);
		    $this->errorCode=self::ERROR_NONE;
		}
			
		return !$this->errorCode;
	}
	
	public function getId()
	{
	    return $this->_id;
	}
}