<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
Yii::import('application.vendors.*');
require_once('dates/format.php');
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/live';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $submenu1 = '';
	
	public $other = '';
	
	public $footer;
	/*返回总数*/
	public function totalETFs(){
	    echo FundProfiles::model()->count();
	}
	
	/* 处理修正后的formatter返回值
	 * @param $result mixed
	 * return array($data.$suffix)
	 * */
	public function dealFormat($result){
	    if(is_array($result)){
	        if(count($result)==2)
	            return $result;
	        else if(count($result)==1)
	            return [$result[0],''];
	        else 
	            return ['',''];
	    }
	    else return [$result,''];
	}
	
	/* 用yii::app的方式从数据库中获取全部数据到一个数组中
	 * @param $sql string
	 * return $data array
	 * */
	public function readAllFromDB($sql){
	    $command = Yii::app()->db->createCommand($sql);
	    $data = $command->query()->readAll();
	    return $data;
	}

	
	/* 返回头部的导航条
	 * @param $title string 主标题
	 * @param $content string 描述
	 * @param $title2 string 子标题
	 * @param $flag string 判断是否需要显示查找到的数量
	 * */
	public function header($title,$content,$title2='',$flag=false){
	    $str = '<div class="below_banner_sec">
                <div class="below_banner_sec_shadow"></div>
                <div class="pagination">
                    <a href="/fundprofiles/index">Home</a> > <a href="#">'.$title.'</a>';
	    if($title2)$str .= ' > ' . $title2;
        $str .= '</div></div><h1 style="font-size:xx-large;color:rgb(54,95,145)">';
        if($title2)$str .= $title2;
        else $str .= $title;
        $str .='</h1><div style="font-family:Cambria;margin-bottom:5px;color:rgb(78,129,200)">'.$content.'</div>';
        if($flag)$str.='<div class="etf_found_sec_cont"><h2>Found <span class="fundNumber">0</span> of <span>'.$this->totalETFs().'</span> ETFs</h2></div>';
        echo $str;
	}
	
	/* 判断类型是否在[string,dateStr,dateStrFromDB]中，若是则返回true,否则返回false
	 * @param $format string
	 * return boolean
	 * */
	public function judgeType($format){
	    if($format == 'string' || $format == 'dateStr' || $format == 'dateStrFromDB')return true;
	    else return false;
	}
	
	/* 获得格式化后的数           现在应该不在使用
	 * @param $field string (label)
	 * @param $row object (fundper 中的一条记录)
	 * return $result string
	 * */
	public function changeField($label,$row){
	    $format = Formats::model()->find('label=:label',array(':label'=>$label));
	    $field = $format->field;//netAssets
	    if($format->precision==0 && $this->judgeType($format->format))
	        $result = format::formatter($row->$field, $format->format);
	    else
	        $result = format::formatter($row->$field, $format->format,$format->precision);
	    return $result;
	}
	
	/* 获得格式化后的数
	 * @param $field string (label)
	 * @param $row object (fundper 中的一条记录)
	 * return $result mixed(array or string)
	 * */
	public function changeField2($label,$row){
	    $format = Formats::model()->find('label=:label',array(':label'=>$label));
	    $field = $format->field;//netAssets
	    if($format->precision==0 && $this->judgeType($format->format))
	        $result = format::formatter2($row->$field, $format->format);
	    else
	        $result = format::formatter2($row->$field, $format->format,$format->precision);
	    return $result;
	}
	
	/*弹框*/
	public function redirect_message($message='success', $status='success',$time=3, $url=false )
	{
	
	    $back_color ='#ff0000';
	
	    if($status =='success')
	    {
	        $back_color= 'green';
	    }
	
	    if(is_array($url))
	    {
	        $route=isset($url[0]) ? $url[0] : '';
	        $url=$this->createUrl($route,array_splice($url,1));
	    }
	    if ($url)
	    {
	        $url = "window.location.href='{$url}'";
	    }
	    else
	    {
	       $url = "history.back();";
	    }
        echo <<<HTML
    	    <div>
        	    <div style="background:#ECECEC; margin:0 auto; height:120px; width:300px; text-align:center;border:1px solid silver">
                    <div style="margin-top:5px;">
                        <h5 style="color:{$back_color};font-size:14px; padding-top:20px;" >{$message}</h5>
                        please wait<span id="sec" style="color:blue;">{$time}</span>seconds
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                function run(){
                    var s = document.getElementById("sec");
                    if(s.innerHTML == 0){
                    {$url}
                        return false;
                    }
                    s.innerHTML = s.innerHTML * 1 - 1;
                }
                window.setInterval("run();", 1000);
            </script>
HTML;
    }

    
    /* 获取子导航的html code
     * @param $result string
     * @param $tree object
     * @param $time int 计数
     * @param $className 表名
     * return $result string
     * */
    public function readSubmenu($result,$tree,$time,$className){
        //judge the tree has son or not
         if($tree){
            $time++;
            if($time == 0){
                $result .= '<ul class="submenu">';
            }else if($time >0){
                $class = 'sub_level'.$time.'_menu';
                $result .= '<ul class='. $class .'>';
            }
            foreach($tree as $row){
                if($className =='FinderEntries'){
                    $where = $this->handleStr($row->whereClause);
                    $result .= '<li ><a href="/inside/index?sql='.$where.'">'. $row->name;
                }
                else {
                    if($time==-1){
                        $name = $this->changeName($row->name);
                        $result .= '<li class="pr"><a href="'.$name.'">'. $row->name.'</a>';
                        $result .= '<div class="black_arrow"><img src="/images/black-arrow.png" alt="Pointer"></div>';
                    }else {
                        $name = $this->changeName($row->name);
                        $result .= '<li><a href="'.$name.'">'. $row->name.'</a>';
                    }
                }
                $row = $className::model()->findAll('parent=:parent',array(':parent'=>$row->id));
                $result = $this->readSubmenu($result,$row,$time,$className);
                $result .= '</li>';
            }
            $result .= '</ul>';
            if($className=='FinderEntries' && $time==0){
                $result .='<div class="bottom_menu_border"><a href="#">More on ETFLive Classification System</a></div>';
            }
        }
        return $result; 
    }
    
    
    //add the real url
    function changeName($name){
        switch($name){
            case 'Quick Finder':
                return '/inside/quickfinder';
            case 'Fund Screener':
                return '/inside/found';
            case 'Related ETF Finder':
                return '/inside/related';
            case 'Screen by Issuer':
                return '/inside/issuer';
            case 'Screen by Index Sponsor':
                return '/inside/indexsponsor';
            case 'Screen by Index':
                return '/inside/indexs';
            case 'Search ETF Holdings':
                return '/inside/holdings';
            case 'ETF Compare Tool':
                return '/chart/compareTool';
            case 'Quotes&Analysis':
                return '/chart/quotesAndCharting';
            case 'Market Quote' :
                return '/chart/marketQuote';
            case 'Historical Returns Tool':
                return '/chart/historicalTool';
            default:
                return '#';
        }
    }
    
    //加密
    public function handleStr($where){
        $pattern = array('/"/','/=/');
		$replace = array('888','999');
		return preg_replace($pattern,$replace,$where);
    }
    
    //解密
    public function handleStr2($where){
        $pattern = array('/888/','/999/');
        $replace = array("'",'=');
        return preg_replace($pattern,$replace,$where);
    }
    
    //日期转换函数
    public function changeDate($date){
        $diff=time()-strtotime($date);
        $date = ceil($diff/(360*24*60*60));
        return $date;
    }
    
    /*获得尾部html*/
    public function footer($foot,$tree){
        foreach($foot as $row){
            if(!$row){return $tree;}
            $name = $this->changeName($row->name);
            $tree .='<li><a href="'.$name.'">'. $row->name .'</a></li>';
        }
        return $tree;
    }
    
    
    
    public function init(){
        //show the ETF Universe
        $result = '';
        $time = -1;
        $className = 'FinderEntries';
        $tree1 = $className::model()->findAll('parent=:parent',array(':parent'=>0));
        $this->submenu1 = $this->readSubmenu($result, $tree1, $time,$className);
        
        //show the other
        $other = '';
        $times = -2;
        $classNames = 'MainMenuEntries';
        $trees = $classNames::model()->findAll('parent=:parent',array(':parent'=>0));
        $this->other = $this->readSubmenu($other, $trees, $times,$classNames); 
        
        //show the footer
        $foot = FooterEntries::model()->findAll('parent=:parent',array(':parent'=>0));
        $tree = '';
        if($foot){
            foreach($foot as $row){
                if($row->name == 'Legal'){$tree .= '<div class="footer_col">';}
                else if($row->name == 'Contact Us'){$tree .= '<div class="footer_col" style="margin-right:0px !important;">';}
                else {$tree .= '<div class="footer_col dis_foot_none">';}
        
                if($row->name ==  'Contact Us'){$tree .= '<h3>'. $row->name .'</h3><ul style="border:none !important;">';}
                else {$tree .= '<h3>'. $row->name .'</h3><ul>';}
        
                $foot = FooterEntries::model()->findAll('parent=:parent',array(':parent'=>$row->id));
                if($foot){$tree = $this->footer($foot,$tree);}
                $tree .='</ul></div>';
            }
        }
        $this->footer = $tree;
    }
    

}