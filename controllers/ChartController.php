<?php

class ChartController extends Controller{
    
    public $layout='//layouts/live2';
    
    public function actionCalculator(){
        $this->render('calculator');
    }
    
    /* 拼接sql语句
     * @param array $get
     * @return string $sql
     * */
    public function getSql($ticker){
        $sql = 'ticker in (';
        foreach($ticker as $row){
            $sql .= '"'.htmlspecialchars($row).'",';
        }
        $sql = substr($sql,0,strlen($sql)-1);
        $sql .= ')';
        return $sql;
    }
    
    /* 返回图标所需要的json格式的数据
     * @param $fundper object
     * @param $column  string
     * return $asset   string(json)
     * */
    public function getChart($funper,$column){
        $suffix = '';
        $asset = '{"data":[';
        foreach($funper as $key => $row){
            global $suffix;
            //处理成含有字符的值,highchart不识别，要将前缀后缀分离出来
            $result = $this->changeField2($column, $row);
            list($data,$suffix) = $this->dealFormat($result);
            $asset .= '{"name":"'.$row->ticker.'","data":['.$data.']},';
        }
        $asset = trim($asset,',');
        $asset .= '],';
        $asset .= '"suffix":"'.$suffix.'"}';
        //if($column == 'Age'){echo $asset;exit;}
        return $asset;
    }
    
    /* 动态添加一个table(1~5列都有可能,即1~5个etf进行比较)
     * @param $fundper object
     * return $table string
     * */
    public function getTable($fundper,$title){
        $table = '<thead><tr><th></th>';
        foreach($fundper as $k => $row){
            $table.='<th>'.$row->ticker.'</th>';
        }
        $table.='</tr></thead><tbody>';
        foreach($title as $val){
            $table .='<tr class="odd"><td>'.$val.'</td>';
            foreach ($fundper as $row){
                $value = $this->changeField($val, $row);
                $table.='<td>'.$value.'</td>';
            }
            $table.='</tr>';
        }    
        $table .= '</tbody>';
        return $table;
    }
    
    /* 获得所有柱状图数据
     * @param $funper object
     * return $result string
     * */
    public function getAllCharts($funper,$title){
        $result = '{';
        foreach($title as $row){
            $result.= '"'.$row.'":'.$this->getChart($funper, $row).',';
        }
        $result = trim($result,',');
        $result .= '}';
        return $result;
    }
    
    /*现将$funper进行循环再将$title进行循环(折线图需要的数据格式)*/
    public function getLineCharts($funper,$title){
        $result = '[';
        foreach($funper as $row){
            $result.= $this->getLine($title, $row);
            $result.= ',';
        }
        $result = trim($result,',');
        $result .= ']';
        return $result;
    }
    
    /*获得tab2的详细数据*/
    public function getLine($title,$row){
        $per = '{"name":"'.$row->ticker.'","data":[';
        $suffix = '';
        foreach($title as $label){
            $result = $this->changeField2($label, $row);
            if(is_array($result))list($data,$suffix) = $result;
            else $data = $result;
            $per .= $data .',';
        }
        $per = trim($per,',');
        $per .= ']}';
        return $per;
    }
    
    public function actionCompareTool(){
        //first turn in
        if(isset($_GET['ticker'])){
            $ticker = explode(',',$_GET['ticker']);
            $sql = $this->getSql($ticker);
            $funper = FundPer::model()->findAll($sql);
            if(empty($funper)){$this->render('/common/tips',array('tips'=>"can't find the data!"));}
            
            $basic = ['Issuer','Fund Type','Exchange','Index Name'];
            $titleChart4 = ['Volatily 30 Day','Volatlity 1Y','Beta (S&P 500)','Beta (Barclay\'s Ag)','Correl (S&P 500)','Correlation (Barclay\'s Ag)'];
            $titleChart3 = ['Trading Volume (1M)','Trading Volume (3M)','Number of Holdings','Weighting of Top 3 Holdings','Weighting of Top 10 Holdings','Beta (AGG)'];
            $titleChart2 = ['1 Month','3 Month','Year To Date','1 Year','3 Year','5 Year'];
            $titleChart1 = ['Net Assets','Expense Ratio','Age','Total Return (1Y)','Volatility (1Y)','Beta (SPY)'];
            
            $titleTable1 = array_merge($titleChart1,$basic);
            $titleTable2 = array_merge($titleChart2,$basic);
            $titleTable3 = array_merge($titleChart3,$basic);
            $titleTable4 = array_merge($titleChart4,$basic);
            $titleTable5 = array_merge($titleChart1,$titleChart2,$titleChart3,$titleChart4,$basic);
            /*ajax 返回table*/
            if(isset($_GET['title'])){
                switch ($_GET['title']){
                    case 'profile':
                        echo $this->getTable($funper,$titleTable1);exit;
                    case 'performance':
                        echo $this->getTable($funper,$titleTable2);exit;
                    case 'trading':
                        echo $this->getTable($funper,$titleTable3);exit;
                    case 'risk':
                        echo $this->getTable($funper,$titleTable4);exit;
                    case 'summary':
                        echo $this->getTable($funper,$titleTable5);exit;
                }
            }
            
            //给tab4添加数据
            $tab4 = $this->getAllCharts($funper,$titleChart4);
            //给tab3添加数据
            $tab3 = $this->getAllCharts($funper,$titleChart3);
            //给tab2添加数据
            $tab2 = $this->getLineCharts($funper,$titleChart2);//现将$funper进行循环再将$title进行循环(折线图需要的数据格式)
            //获得tab1所有柱状表的数据
            $tab1 = $this->getAllCharts($funper,$titleChart1);//现将$title进行循环再将$fundper进行循环(柱状图需要的数据格式)

            //动态添加一个table(1~5列都有可能,即1~5个etf进行比较)
            $table = $this->getTable($funper,$titleTable1);
            
            $this->render('compareTool',array('tab2'=>$tab2,'result'=>$tab1,'tab3'=>$tab3,'tab4'=>$tab4,'table'=>$table,'ticker'=>$ticker));
        }else 
            $this->render('/fundprofiles/index');
    }
    
    public function actionMarketQuote(){
        $fund = FundProfiles::model()->find('id=14');
        /*get the data about the top 10*/
        $key = $fund->ticker;
        $sql = 'select `Constituent Name` as company,`Constituent Ticker` as ticker,Weighting as weight
            from ConstituentData where `Composite Ticker`="'.$key.'" order by Weighting desc limit 10';
        $holdings=$this->readAllFromDB($sql);
        $this->render('/chart/marketQuote',array('res'=>$fund,'holdings'=>$holdings));
    }
    
    public function actionHistoricalTool(){
        $this->render('/chart/historicalTool');
    }
    
    public function actionQuotesAndCharting(){
        $this->render('quotesAndCharting');
    }
    
}