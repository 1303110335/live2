<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $emailaddress;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('emailaddress, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->emailaddress,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect email or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->emailaddress,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	
	/*
	 * @param object $model 登录模型
	 * @param array  $data  post提交的数据
	 * @param boolean $ajax 是ajax提交的还是直接post提交的
	 * */
	public function commonLogin($model,$data,$ajax){
	    if(!empty($data))
	    {
	        $model->attributes=$data;
	        // validate user input and redirect to the previous page if valid
	        if($model->validate() && $model->login()){
	            $userId = Yii::app()->user->id;
	            $user = User::model()->findByPk($userId);
	            $this->addLoginCount($user,$userId);
	            if($ajax){
	                return $user->username;
	            }
	            else {return true;}
	        }
	        else{
	            if($ajax){echo '';exit;}
	            else return false;
	        }
	    }
	}
	
	public function addLoginCount($user,$userId){
	    //add logincount
	    $user->logincount +=1;
	    $user->save();
	     
	    //save logs
	    $log = new UserLogs();
	    $log->ipaddress = $_SERVER['REMOTE_ADDR'];
	    $log->userid = $userId;
	    $log->urlaccessed = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:$_SERVER['REQUEST_URI'];
	    $log->save();
	}
}
