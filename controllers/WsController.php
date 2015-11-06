<?php

class WsController extends Controller
{
    public function actionAuthenticate($ip,$username,$pwd){
        if(!empty($ip)&&!empty($username)&&!empty($pwd)){
            if($this->auth($ip,$username,$pwd)) echo "User authenticated";
            else echo "User not authenticated";
        }
        else echo "Unable to process service request";
    }
    
    public function actionServiceRequest($ip,$username,$pwd,$request,$param){
        if(!empty($ip)&&!empty($username)&&!empty($pwd)&&!empty($request)&&!empty($param)){
            if($this->auth($ip,$username,$pwd)){
                $sql = WebServices::model()->find('userField=:request',array(':request'=>$request));
                //have result but the sql is ''
                if(!$sql->selectStatement){echo "Unable to process service request";exit;}
                $sql = str_replace('{Param1}', $param , $sql->selectStatement);
                $command = Yii::app()->db->createCommand($sql);
                $data = $command->query()->readAll();
                echo json_encode($data);
            }
            else echo "User not authenticated";
        }
        else echo "Unable to process service request";
    }
    
    public function auth($ip,$username,$pwd){
        if($ip=='127.0.0.1'){
            $user = User::model()->find('username=:username',array(':username'=>$username));
            if($user->password == $pwd){
                $form = new LoginForm();
                $form->addLoginCount($user,$user->id);
                return true;
            }
            else return false;
        }
        else return false;
    }
}
