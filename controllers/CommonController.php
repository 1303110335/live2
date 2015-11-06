<?php

class CommonController extends Controller
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
                'actions'=>array('tips'),
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
    
    public function actionTips(){
        $this->render('/common/tips'); 
    }
    
    
}
