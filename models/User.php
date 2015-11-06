<?php

class User extends CActiveRecord{
    public $password2;
    public $checkETF;
    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'Users';
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        return array(
            array('username','required'),
            array('username','unique'),
            array('emailaddress','email'),
            array('emailaddress','required'),
            array('emailaddress','unique'),
            array('checkETF','equalTrue','on'=>'register'),
            array('password','required','on'=>'insert'),
            array('password,password2','required','on'=>'register,passwdUpdate'),
            array('password2','compare','compareAttribute'=>'password','on'=>'register,passwdUpdate'),
            array('lastlogin', 'default', 'value' => new CDbExpression('NOW()')),
            array('investortype','required','on'=>'register'),
        );
    }
    
    public function equalTrue($attribute){
        if($this->checkETF==0){
            $this->addError($attribute,'you should check the ETF terms of use');
        }
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'checkETF' => 'I agree to the ETFLive, <a href="#">Terms of use</a>',
        );
    }
    
    /*send email*/
    public function SendEmail($content,$from,$name,$to,$password,$title){
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = 'smtp.qq.com';
        $mailer->IsSMTP();
        $mailer->SMTPAuth = true;
        $mailer->From = $from;
        $mailer->AddReplyTo($from);
        $mailer->AddAddress($to);
        $mailer->FromName = $name;
        $mailer->Username = $name;    //这里输入发件地址的用户名
        $mailer->Password = $password;    //这里输入发件地址的密码
        $mailer->SMTPDebug = false;   //设置SMTPDebug为true，就可以打开Debug功能，根据提示去修改配置
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = Yii::t('demo', $title);
        $mailer->Body = $content;
        $mailer->IsHTML(true);
        $mailer->Send();
        
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($class=__class__){
        return parent::model($class);
    }
}