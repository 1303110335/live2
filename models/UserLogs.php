<?php

class UserLogs extends CActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'UserLogs';
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        return array(
            array('userid','required'),
            array('ipaddress','required'),
            array('datetimes','default','value'=>new CDbExpression('NOW()')),
            array('urlaccessed','required')
        );
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