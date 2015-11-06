<?php

class fundprofilesController extends Controller
{
    
    public function filters(){
        return array(
            'accessControl',
        );
    }
    
    public function accessRules(){
        return array(
            array(
                'allow',
                'actions'=>array('index','pass','resetpsw','login','register','sendemail','ResetPasswd','check','logout'),
                'users'=>array('*'),
            ),
            array(
                'allow',
                'actions'=>array(),
                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex(){
        $this->render('/fundprofiles/index'); 
    }
    
    public function actionPass(){
        $this->render('/fundprofiles/pass');
    }

    /*email send*/
    public function actionSendEmail(){
        $email = $_POST['emailaddress'];
        $content="<a href='http://live.dev/fundprofiles/resetpasswd?name=".$email."'>click this link to reset your password</a>";
        User::model()->SendEmail($content, '1303110335@qq.com','1303110335',$email, '49910310xlya', 'resetpw');
        $this->render('tips',array('tips'=>'email is sending,please wait for a minute!'));
    }
    
    /*reset passwd*/
    public function actionResetPasswd($name=''){
        $model = User::model()->find('emailaddress=:name',array(':name'=>$name));
        //have something wrong
        if(!$model)$this->render('/fundprofiles/index');
        $model->scenario = 'passwdUpdate';
        if(isset($_POST['User']))
        {
            $_POST['User']['password']=md5($_POST['User']['password']);
            $_POST['User']['password2']=md5($_POST['User']['password2']);
            $model->attributes = $_POST['User'];
            if($model->save()){
                Yii::app()->user->setFlash('success','resetPw succeed');
            }
        }
        $model->password = "";
        $model->password2 = "";
        $this->render('resetpsw',array('model'=>$model));
    }
    

    public function actionLogin(){
        $model=new LoginForm;
        $flag = false;
        if($_POST['emailaddress']){
            extract($_POST);
            $emailaddress=htmlspecialchars($emailaddress);
            $password = htmlspecialchars($password);
            $data = [
                'emailaddress'=>$emailaddress,
                'password'=>$password
            ];
            $flag = $model->commonLogin($model,$data,true);
            if($flag)echo $flag;
            exit;
        }
        
        if(isset($_POST['LoginForm']))
            $flag = $model->commonLogin($model,$_POST['LoginForm'],false);
        if($flag){$this->render('/fundprofiles/index');exit;}
        // display the login form
        $this->render('/fundprofiles/login',array('model'=>$model));
    }

    
    /*register*/
    public function actionRegister(){
        $model = new User();
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        $model->scenario = 'register';
        $model->unsetAttributes();
        if(isset($_POST['User']))
        {  
            if(!empty($_POST['User']['password']) && !empty($_POST['User']['password2']) && $_POST['User']['password2'] == $_POST['User']['password']){
                $_POST['User']['password'] = md5($_POST['User']['password']);
                $_POST['User']['password2'] = md5($_POST['User']['password2']);
            }
            $model->attributes=$_POST['User'];
            if($model->save()){
                //Yii::app()->user->setFlash('success','register succeed');
                $this->render('/fundprofiles/index');
            }
        }
        $model->username = "";
        $model->password = "";
        $this->render('/fundprofiles/register',array('model'=>$model));
    }
    

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/Fundprofiles/index');
    }
    
}
