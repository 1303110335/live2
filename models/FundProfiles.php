<?php

class FundProfiles extends CActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'FundProfiles';
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        return array(
            array('id,ticker,fullName,expenseRatio,investmentAdvisor','safe','on'=>'search'),
        );
    }
    
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'detail'=>array(self::HAS_ONE, 'PerformanceMetrics', 'ticker'),
        );
    }
    
    public function search(){
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('ticker', $this->ticker, true);
        $criteria->compare('fullName', $this->fullName, true);
        $criteria->compare('expenseRatio', $this->expenseRatio, true);
        $criteria->compare('investmentAdvisor', $this->investmentAdvisor, true);
        $criteria->compare('firstTradeDate',$this->firstTradeDate,true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
    
    public static function get_id_by_tickr($ticker){
        $result = self::model()->find('ticker=:ticker',array(':ticker'=>$ticker));
        return $result->id;
    }
    
    
}