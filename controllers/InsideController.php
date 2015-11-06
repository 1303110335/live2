<?php

Yii::import('application.vendors.*');
require_once('dates/format.php');
require_once('market/dividends.php');

class InsideController extends Controller{
    
    public $layout='//layouts/live2';
    
    public function filters(){
        return array(  
            'accessControl', 
        );
    } 
    
    public function accessRules(){
        return array(
            array(
                'allow',
                'actions'=>array('index','calculator','investment','found','quickfinder',
                    'related','issuer','indexsponsor','indexs','holdings','fundviewer','test'),
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
    
    public function actionTest(){
        $this->render('/inside/test');
    }
   
    public function actionIndex(){
        
        if(isset($_GET['sqls'])){
            
            // "assetClass='Glbl/IntlStocks' AND regionFocus='Asia Pacific' AND countryFocus='China'"
            $sql = trim($this->handleStr2(urldecode($_GET['sqls'])));
            //add the order and key
            $order = "";
            if(isset($_GET['order'])) {
                $order = $this->orderByKey($_GET['order'],$_GET['key']);
                $order = str_replace("'",'"',$order);
            }
            $sql ="select * from fundPer where ".$sql.$order;
            $this->addPager($sql);
        } 
        $this->render('index');
    }
    
    public function actionFundViewer(){
        //order by desc
        if(isset($_POST['keyword'])){
            $key = $_POST['keyword'];
            $sql = 'select * from fundPer where ticker in (SELECT distinct tickerB FROM `Correlations` where tickerA = "'.$key.'" and rho > 0.9 and rho <1) union '.
                   'select * from fundPer where ticker in (SELECT distinct tickerA FROM `Correlations` where tickerB = "'.$key.'" and rho > 0.9 and rho <1)';
            
            if(isset($_POST['order'])){
                $sql .= $this->orderByKey($_POST['order'],$_POST['key']);
            }
            $res = FundPer::model()->findAllBySql($sql);
            $this->echoAjaxArray($res);
            exit;
        }

        $this->getAllHoldings();
        
        if(isset($_GET['ticker'])){
            //FBND - Fidelity Total Bond ETF
            $ticker = htmlspecialchars($_GET['ticker']);
            list($ticker,) = explode(' - ',$ticker);
            
            /* $summaryObj = get_obj_from_xml($ticker);
            $Change = $summaryObj->Change;
            $summaryObj->percent = number_format(((float)$Change *100)/$summaryObj->Last , 2);  */
            //distributes
            //$distributes = $this->get_distributes($ticker);
            
            $id = FundProfiles::get_id_by_tickr($ticker);
            //data for detail of ETF
            $fund = FundProfiles::model()->find('id='.$id);

            //$performance = PerformanceMetrics::model()->find('ids='.$id);

            /* $key = $fund->ticker;
            $sql = 'select `Constituent Name` as company,`Constituent Ticker` as ticker,Weighting as weight from ConstituentData where `Composite Ticker`="'.$key.'" order by Weighting desc limit 10';
            $holdings=$this->readAllFromDB($sql); */
            
            //$relations = $this->getDataForRelations($key);
            
            $all = array('res'=>$fund,
                         //'holdings'=>$holdings,
                         //'performance'=>$performance,
                         //'relations'=>$relations,
                         //'summary'=>$summaryObj,
                         //'dividends'=>$distributes
                );
            
            $this->render('summarysheet',$all);
        }        
    }
    
    public function getDataForRelations($key){
        //data for relations
        $sql = 'select * from fundPer where ticker in (SELECT distinct tickerB FROM `Correlations` where tickerA = "'.$key.'" and rho > 0.9 and rho <1) union '.
            'select * from fundPer where ticker in (SELECT distinct tickerA FROM `Correlations` where tickerB = "'.$key.'" and rho > 0.9 and rho <1) limit 20';
        return FundPer::model()->findAllBySql($sql);
    }
    
    public function getAllHoldings(){
        if(isset($_POST['name'])){
            $key = $_POST['name'];
            $sql = 'select `Constituent Name` as company,`Constituent Ticker` as ticker,Weighting as weight from ConstituentData where `Composite Ticker`="'.$key.'" order by Weighting desc';
            $command = Yii::app()->db->createCommand($sql);
            $dataReader = $command->query();
            $result = '';
            $flag = false;
            while(($row=$dataReader->read())!==false){
                if($flag)$result .='<tr class="odd">';
                else $result .='<tr>';
                $result .='<td>'.$row['company'].'</td><td>'.$row['ticker'].'</td><td>'.$row['weight'].'</td></tr>';
                $flag = !$flag;
            }
            echo $result;exit;
        }
    }
    
    public function get_distributes($ticker){
        $divs = new dividends($ticker, null);
        $divs->setDateRange(dateDBDateToMktime("2000-01-01"), dateDBDateToMktime("2015-10-01"));
        $haveDataOrEmpty = $divs->loadDivs();
        $result = array();
        if($haveDataOrEmpty){
            $result = $divs->xml->GetCashDividendHistoryResult->Dividends->Dividend;
        }
        return $result;
    }
    
    public function actionHoldings(){
        
        if(isset($_POST['search'])){
            $searchText = htmlspecialchars($_POST['search']);
            $sql = "select distinct `Constituent Ticker` as ticker,`Constituent Name` as name from `ConstituentData` 
                where `Constituent Ticker` like '". $searchText ."%' or `Constituent Name` LIKE '". $searchText ."%' limit 5";
            $command = Yii::app()->db->createCommand($sql);
            $dataReader=$command->query();
            $res = '';
            while(($row=$dataReader->read())!==false) {
                $res .= '<li>'. $row['ticker'] .' - '. $row['name'] .'</li>';
            }
            echo $res;
            exit;
        }
        
        if(isset($_GET['keyword'])){
            $keyword = htmlspecialchars($_GET['keyword']);
            if(!is_int(strpos($keyword,"'"))){$keyword="\'".$keyword;}
            $sql = 'select distinct DISTINCT c.`Composite Ticker`,f.* from ConstituentData as c , fundPer as f where 
                c.`Composite Ticker` = f.ticker AND c.`Constituent Ticker` = "'.$keyword.'"';
            if(!empty($_GET['weight']))
                $sql.=' and c.Weighting <'.$_GET['weight'];
            
            if(isset($_GET['inver']))
                $sql .= $this->fixInver($_GET['inver']);
            
            if(isset($_GET['order']))
                $sql .= $this->orderByKey($_GET['order'],$_GET['key']);
            
            $this->addPager($sql);
        }
        
        $this->render('holdings');
    }
    
    public function fixInver($inver){
        switch($inver){
            case 'InverseIndicator':
                return ' and f.inverseIndicator ="N"';
            case 'fundLeverage':
                return ' and f.fundLeverage = "N"';
            case 'all':
                return ' and f.inverseIndicator ="N" and f.fundLeverage = "N"';
        }
    }
    
    public function actionIndexs(){
        if(isset($_POST['index'])){
            $result = FundProfiles::model()->findAll('indexName=:index',array(':index'=>$_POST['index']));
            $res = '';
            foreach($result as $row){
                $res .= '<li value="'. $row->id .'">'. $row->fullName .'</li>';
            }
            $num = count($result);
            print_r(CJSON::encode(['num'=>$num,'res'=>$res]));exit;
        }
        $result = FundProfiles::model()->findAllBySql('select distinct indexName from FundProfiles;');
        $this->render('indexs',array('result'=>$result));
    }
    
    public function actionIndexSponsor(){
        if(isset($_POST['index'])){
            $result = FundProfiles::model()->findAll('indexSponsor=:index',array(':index'=>$_POST['index']));
            $res = '';
            foreach($result as $row){
                $res .= '<li value="'. $row->id .'">'. $row->fullName .'</li>';
            }
            $num = count($result);
            print_r(CJSON::encode(['num'=>$num,'res'=>$res]));exit;
        }
        
        $result = FundProfiles::model()->findAllBySql('select distinct indexSponsor from FundProfiles;');
        $this->render('indexsponsor',array('result'=>$result));
    }
    
    public function actionIssuer(){
        //first click
        if(isset($_POST['issu'])){
            $sql = 'select * from FundProfiles where issuer = "'.$_POST['issu'].'"';
            $pro = FundProfiles::model()->findAllBySql($sql);
            $res = '';
            foreach($pro as $row){
                $res .= '<li value="'. $row->id .'">'. $row->fullName .'</li>';
            }
            $num = count($pro);
            print_r(CJSON::encode(['num'=>$num,'res'=>$res]));exit;
        }
        
        /*second click*/
        if(isset($_POST['name'])){
            $result = FinderEntries::model()->find('name=:name',array(':name'=>$_POST['name']));
            $sql = 'select * from FundProfiles where issuer = "'.$_POST['issuer'].'" and '.$result->whereClause;
            $pro = FundProfiles::model()->findAllBySql($sql);
            $res = '';
            foreach($pro as $row){
                $res .= '<li value="'. $row->id .'">'. $row->fullName .'</li>';
            }
            echo $res;exit;
        }
        
        $result = FundProfiles::model()->findAllBySql("select distinct issuer from FundProfiles order by issuer;");
        
        $result2 = FinderEntries::model()->findAll('parent=0');
        $this->render('issuer',array('result'=>$result,'result2'=>$result2));
    }
     
    public function actionInvestment(){
        //show the detail for one ETF
        $one = FundProfiles::model()->find('id=2');
        
        $this->render('investment',array('row'=>$one));
    }
    
    public function showCheckList(){
        //show the checkboxlist
        $res = FinderEntries::model()->findAll('parent=0');
        $arr = array();
        $i=0;
        foreach($res as $row){
            $arr[$i][] = $row->name;
            $tree = FinderEntries::model()->findAll('parent='.$row->id);
            foreach($tree as $row){
                $arr[$i][] = $row->name;
            }
            $i++;
        }
        return $arr;
    }
      
    //format the min or max value
    public function format($holdings,$format){
        
        if($format->precision != 0){
            //转化出来的单位要相同，可能会出问题
            $holdings['mins']=format::formatter2($holdings['min'], $format->format,$format->precision);
            $holdings['maxs']=format::formatter2($holdings['max'], $format->format,$format->precision);
        }else{
            $holdings['mins']=format::formatter2($holdings['min'], $format->format);
            $holdings['maxs']=format::formatter2($holdings['max'], $format->format);
        }
        return $holdings;
    }

    
    public function actionFound(){   
        //show the checkboxlist
        $arr = $this->showCheckList();
        
        if(isset($_GET['All'])){
            $sql = "select * from fundPer";
            $this->addPager($sql);
        }
        
        /*search for min and max about age etc*/
        if(isset($_GET['max'])){
            $format = Formats::model()->find('label=:label',array(':label'=>$_GET['max']));
            $sql = "select MIN($format->field) as min,MAX($format->field) as max from fundPer ;";
            //put all data into $holdings
            $holdings = $this->readAllFromDB($sql);
            $holdings = $this->format($holdings[0], $format);
            print_r( CJSON::encode($holdings));exit;
        }
        
        //in small case add data
        if(isset($_GET['results'])){
            $sql = 'SELECT * FROM fundPer where ';
            $sql.= $this->fixResult($_GET['results']);
            $sql.= $this->getAssetClass($_GET['arrs']);
            $sql.= $this->searchByKeyWord($_GET['keywords']);
            $res = FundPer::model()->findAllBySql($sql);
            $this->echoSmallAjax($res);
        }
        
        //show the result filter by silder
        /*result array(from,to,title)*/
        if(!empty($_GET['object'])){
            $sliderObj = $_GET['object'];
            $sql = 'SELECT * FROM fundPer where ';
            $sql.= $this->fixResult($sliderObj['rangeNumber']);
            $sql.= $this->getAssetClass($sliderObj['checkNumber']);
            $sql.= $this->getInverse($sliderObj['inverseNumber']);
            $sql.= $this->searchByKeyWord($sliderObj['searchByKeyWord']);
            $sql.= $this->orderByKey($sliderObj['orderRule'],$sliderObj['orderByKey']);
            $this->addPager($sql);
        }
        $this->render('found',array('arr'=>$arr));  
    }
    
    public function addPager($sql){
        $fund = FundPer::model()->findAllBySql($sql);
        $cnt = count($fund);
        if($cnt>10){
            $per = 10;
            $page = new Page($cnt,$per);
            //add the limit
            $sql.=' '.$page->limit;
            $res = FundPer::model()->findAllBySql($sql);
            if(!$res) {echo '';exit;}
            $this -> echoAjaxArray($res,$page->fpage(),$cnt);
            exit;
        }else{
            if(!$fund){echo '';exit;}
            $this -> echoAjaxArray($fund,'',$cnt);
            exit;
        }
    }
    
     public function fixResult($result){
        if(!isset($result))return '';
        $sql = '';
        foreach($result as $all){
            $format = Formats::model()->find('label=:label',array(':label'=>$all['title']));
            if($all['title']=='Age'){
                $from = format::unformatDate($all['to']);
                $to = format::unformatDate($all['from']);
            }else{
                $from = format::preUnformat($all['from']);
                $to = format::preUnformat($all['to']);
            }
            //echo $from;exit;
            $sql .= $format->field.' >= "'.$from .'" and '.$format->field.' <= "'.$to.'"';
            $sql .= ' and ';
        }
        //cut the last 'and'
        return substr($sql,0,-4);
    } 
    
    public function getAssetClass($checkNumber){
        if(!isset($checkNumber))return '';
        $sql = '';
        //get the asset class
        if(!empty($arr)){
            $sql .= ' and ((';
            foreach($arr as $row){
                $model = FinderEntries::model()->find('name=:name',array(':name'=>$row));
                $sql .= $model->whereClause .') or (';
            }
            //cut the last 'or'
            $sql = substr($sql,0,-4);
            $sql .=')';
        }
        return $sql;
    }
    
    public function searchByKeyWord($keyword){
        if(!isset($keyword))return '';
        $sql = '';
        if(!empty($keyword)){
            $sql .= " and (ticker like '". $keyword ."%' or fullName like '". $keyword ."%')";
        }
        return $sql;
    }
    
    public function echoSmallAjax($res){
        $result ='';
        foreach($res as $k => $row){
            if($k==0)$result .= '<div class="table_asset_sec">';
            else $result .= '<div>';
            $result .= '<div class="table_asset_sec_right">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td style="font-weight:600;">'.$row->fullName.'</td>
                                    </tr>
                                    <tr>
                                        <td>Ticker</td>
                                        <td>'.$row->ticker.'</td>
                                    </tr>
                                    <tr>
                                        <td>Age</td>
                                        <td>'.$row->firstTradeDate.'</td>
                                    </tr>
                                    <tr>
                                        <td>Expense Ratio</td>
                                        <td>'.$row->expenseRatio.'</td>
                                    </tr>
                                    <tr>
                                        <td>Assets</td>
                                        <td>'.$row->netAssets.'</td>
                                    </tr>
                                    <tr>
                                        <td>1M Return</td>
                                        <td>'.$row->p1MPR.'</td>
                                    </tr>
                                    <tr>
                                        <td>3M Return</td>
                                        <td>'.$row->p3MPR.'</td>
                                    </tr>
                                    <tr>
                                       <td colspan="2" class="select"><a href="javascript:void(0)" value="'.$row->ticker.'" class="selectMe">Select</a></td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clr"></div>
                    </div>';
        }
        echo $result;exit;
    }
    
    /*add the string order by what desc or asc*/
    public function orderByKey($order,$key){
        if(!isset($order) || !isset($key))return '';
        if(!empty($order) && !empty($key)){
            //change the name of key
            $format = Formats::model()->find('label=:label',array(':label'=>$key));
            if($format)
                return ' order by '. $format->field .' '.$order;
            else
                return ' order by '. $key .' '.$order;
        }
        return '';
    }
    
    public function getInverse($inverseNumber){
        if(!isset($inverseNumber))return '';
        $part = '';
        if(!empty($inver)){
            if(isset($inver['inverse']))
                $part .= " and inverseIndicator = 'N'";
            if(isset($inver['leverage']))
                $part .=" and fundLeverage = 'N'";
        }
        return $part;
    }
    
    public function echoAjaxArray($res,$pager='',$cnt=''){
        $allLabelArrayForTr = [
            ['expenseRatio','investmentAdvisor','firstTradeDate'],
            ['p1MPR','p3MPR','pYTDPR'],
            ['p1YPR','P3YPR','P5YPR'],
            ['adtv30d','adtv30dDollars','numHoldings'],
            ['vol30d','betaSPY','correlSPY']
        ];
        
        $LabelTwoArrayForTr = [];
        foreach($allLabelArrayForTr as $key => $eachLabelArrayForTr){
            $LabelTwoArrayForTr[$key]  = $this->mergeArrayWithBaseLabel($eachLabelArrayForTr);
        }

        $ajaxArray = [];
        foreach($LabelTwoArrayForTr as $key => $labelArrayForTr)
            foreach($res as $k => $row){
                if($k === 0){$ajaxArray[$key+1] = '';}
                $ajaxArray[$key+1] .= $this->addDataForTr($labelArrayForTr,$row);
            }
        
        $ajaxArray[] = $cnt;
        if(!empty($pager))$ajaxArray[] = $pager;
        echo CJSON::encode($ajaxArray);
        exit;
    }
    
    public function mergeArrayWithBaseLabel($differentPartLabelArray){
        $baseLabelArrayForTr = ['ticker','fullName'];
        return array_merge($baseLabelArrayForTr,$differentPartLabelArray);
    }
    
    public function addDataForTr($labelArrayForTr,$row){
        $result = '<tr>';
        foreach($labelArrayForTr as $label){
            $result .='<td class="t-left">'.$row->$label.'</td>';
        }
        $result .='<td><input class="cont" type="checkbox" name="select" value="'.$row->ticker.'" /></td></tr>';
        return $result;
    }
 
    public function actionQuickFinder(){
        //show the detail about one ETF
        if(isset($_POST['etfId'])){
            $tree = FundProfiles::model()->find('id=:id',array(':id'=>$_POST['etfId']));
            echo CJSON::encode($tree->attributes);
            exit;
        }
        
        //find the ETF name
        if(isset($_POST['id'])){
            $tree = FinderEntries::model()->find('id=:id',array(':id'=>$_POST['id']));
            $tree = FundProfiles::model()->findAll($tree->whereClause .' order by netAssets desc');
            $result = '';
            foreach($tree as $row){
                $result .='<li value="'. $row->id .'">'. $row->fullName .'</li>';
            }
            echo $result;
            exit;
        }
        
        //find the first,second column
        if(isset($_POST['name'])){
            $tree = FinderEntries::model()->findAll('parent=:id',array(':id'=>$_POST['name']));
            $result = '';
            foreach($tree as $row){
                $result .='<li value="'. $row->id .'">'. $row->name .'</li>';
            }
            echo $result;
            exit;
        }
        
        $checks = FinderEntries::model()->findAll('parent=0');
        $this->render('quickfinder',array('checkModel'=>$checks));
    }
  
    public function actionRelated(){
        
        if(isset($_POST['search'])){
            $searchText = htmlspecialchars($_POST['search']);
            $sql = "select ticker,fullName from FundProfiles where ticker like '". $searchText ."%' limit 5";
            $result = FundProfiles::model()->findAllBySql($sql);
            $res = '';
            foreach($result as $row){
                $res .= '<li>'. $row->ticker .' - '.$row->fullName.'</li>';
            }
            echo $res;
            exit;
        }
        
        if(isset($_GET['result'])){
            $key = $_GET['keyword'];
            $from = $_GET['result']['from'];
            $to = $_GET['result']['to'];
            //exculde inverse or leverage
            $part = '';
            if(isset($_GET['inver']))$part = $this->getInverse($_GET['inver']);
            //add the order and key
            $order = '';
            if(isset($_GET['order'])) {$order = $this->orderByKey($_GET['order'],$_GET['key']);}
            
            $sql = 'select * from fundPer where ticker in (SELECT distinct tickerB FROM `Correlations` where tickerA = "'.$key.'" and rho > '.$from .' and rho < '.$to.') '. $part .' UNION '.
                    'select * from fundPer where ticker in (SELECT distinct tickerA FROM `Correlations` where tickerB = "'.$key.'" and rho > '.$from .' and rho < '.$to.') '. $part . $order;
            
            $this->addPager($sql);
        }
        $this->render('related');
    }
}







