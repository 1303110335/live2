<?php

Yii::import('application.vendors.market.*');
require_once('market/dates.php');

class format{
    
    static function plainEnglish($n, $precision = 1) {
        if (is_numeric($n)) {
            if ($n > 1000000000)
                $nStr = number_format($n / 1000000000, $precision) . " B";
            elseif ($n > 1000000)
                $nStr = number_format($n / 1000000, $precision) . " M";
            elseif ($n > 1000)
                $nStr = round(($n / 1000), $precision) . " k";
            else
                $nStr = number_format($n, $precision);
        }
        else {
            $nStr = "";
        }
    
        return ($nStr);
    }
    
    /*
     * 
     * Format values ($v) into specified format ($format) and, where applicable, to
     * a certain $precision.
     *  
     * '#':                     Return a readable string for value (120000000000 results in 1.2B)
     * '$':                     Same as '#', but prepends '$' to number
     * '%':                     Return a string formatted as a percent to specified precision (default = 2)
     * '100%':                  Same as '%' but multiplies number by 100 (note additional $precision)
     * '100%00':                Same as 100%, but insures $precision numbers after decimal point
     * 'annual%:                Same as '%', but appends 'p.a.' (for per annum)
     * 'ageFromDB':             Returns a float value represents number of years
     * 'ageStrFromDB':          Returns a string value in years and months
     * 'dateStrFromDB':         From YYYY-MM-DD returns a string formatted as Jun 12, 2010
     * 'shortDateStrFromDB':    From YYYY-MM-DD returns a string formatted as 6/12/10
     * 'dateStr':               From unix time returns a string formatted as Jun 12, 2010
     * 'shortDate':             From unix time returns a string formatted as 6/12/10
     * 
     * default:                 Returns $v
     * 
     */
    
    static function formatter($v, $format, $precision = 2) {
        switch ($format) {
            case "#":
                return (self::plainEnglish($v, $precision));
    
            case '$':
                return ('$' . self::plainEnglish($v, $precision));
    
            case '%':
                return (number_format ($v, $precision) . '%');
    
            case '100%':
                return (number_format ($v * 100, $precision, '.', '') . '%');
    
            case '100%00':
                $nStr = number_format ($v * 100, $precision, '.', '');
                return ($nStr . '%');
    
    
            case 'annual%':
            case 'annualPercent':
                return (number_format($v, $precision) . '% p.a.');
    
            case 'ageFromDB':
                $mktime = dateDBDatetoMktime($v);
                $numDays = dateDiff(time(), $mktime);
                return (round((float) $numDays/365, $precision));
    
            case 'ageStrFromDB':
                $mktime = dateDBDatetoMktime($v);
                $numDays = dateDiff(time(), $mktime);
                $years = round(($numDays / 365), 0);
                $daysRemaining = ($numDays % 365);
                $months = round(($daysRemaining / 30), 0);
                return ($years . 'y ' . $months . 'm');
    
            case 'dateStrFromDB':  // YYYY-MM-DD
                $mktime = dateDBDatetoMktime($v);
                $mktimeStr = date("M j, Y", $mktime);
                return ($mktimeStr);
    
            case 'shortDateStrFromDB':  // YYYY-MM-DD
                $mktime = dateDBDatetoMktime($v);
                $mktimeStr = date("m/d/y", $mktime);
                return ($mktimeStr);
    
            case 'dateStr':
                $mktimeStr = date("M j, Y", $v);
                return ($mktimeStr);
    
            case 'shortDateStr':
                $mktimeStr = date("m/d/y", $v);
                return ($mktimeStr);
    
            default:
                return ($v);
        }
    }
    
    /*return with an array*/
    static function plainEnglish2($n, $precision = 1) {
        $res = [];
        if (is_numeric($n)) {
            if ($n > 1000000000)
                $res = [number_format($n / 1000000000, $precision) , "B"];
            elseif ($n > 1000000)
                $res = [number_format($n / 1000000, $precision) , "M"];
            elseif ($n > 1000)
                $res = [round(($n / 1000), $precision) , "k"];
            else
                $res = [number_format($n, $precision),''];
        }
        return $res;
    }
    
    /*return with an array*/
    //dividendYied 的最小值为0.019999999552965164，需要额外处理一下
    static function formatter2($v, $format, $precision = 2) {
        $result = null;
        switch ($format) {
            case "#":
                $result = self::plainEnglish2($v, $precision);
                break;
            case '$':
                $result = self::plainEnglish2($v, $precision);
                break;
            case '%':
                $result = [number_format ($v, $precision) , '%'];
                break;
            case '100%':
            case '100%00':
                $result = [number_format ($v * 100, $precision, '.', '') , '%'];
                break;
            case 'annual%':
            case 'annualPercent':
                $result = [number_format($v, $precision) , '% p.a.'];
                break;
            case 'ageFromDB':
                $mktime = dateDBDatetoMktime($v);
                $numDays = dateDiff(time(), $mktime);
                $result = (round((float) $numDays/365, $precision));
                break;
            case 'ageStrFromDB':
                $mktime = dateDBDatetoMktime($v);
                $numDays = dateDiff(time(), $mktime);
                $years = round(($numDays / 365), 0);
                $daysRemaining = ($numDays % 365);
                $months = round(($daysRemaining / 30), 0);
                $result = ($years . 'y ' . $months . 'm');
                break;
            case 'dateStrFromDB':  // YYYY-MM-DD
                $mktime = dateDBDatetoMktime($v);
                $mktimeStr = date("M j, Y", $mktime);
                $result = ($mktimeStr);
                break;
            case 'shortDateStrFromDB':  // YYYY-MM-DD
                $mktime = dateDBDatetoMktime($v);
                $mktimeStr = date("m/d/y", $mktime);
                $result = ($mktimeStr);
                break;
            case 'dateStr':
                $mktimeStr = date("M j, Y", $v);
                $result = ($mktimeStr);
                break;
            case 'shortDateStr':
                $mktimeStr = date("m/d/y", $v);
                $result = ($mktimeStr);
                break;
            default:
                $result = ($v);
                break;
        }
        if(!is_array($result)&&self::countDecimal($result)>2){
            $result = number_format($result,2);
        }
        return $result;
    }
    
    //返回小数的长度
    static function countDecimal($num){
        if(strpos($num,'.')!==false){
            $temp = explode('.',$num);
            return strlen($temp[1]);
        }else
            return $num;
    }
    
    
    /**
     *
     * Unformat the string that was previously formatted using formatter ()
     * function.
     *
     * @param type $str
     * @param type $format
     * @return type
     *
     */
    static function unformatter($str, $format) {
        switch ($format) {
            case 'B':
                return (floatval(str_replace('B','',$str))*1000000000);
            case 'M':
                return (floatval(str_replace('M','',$str))*1000000);
            case 'k':
                return (floatval(str_replace('k','',$str))*1000);
            case '%':
                return (floatval(str_replace("%", "", $str)));
            case '% p.a.':
                return (floatval(str_replace("% p.a.", "", $str)));
            case '00%':
                return (floatval(str_replace("00%", "", $str)));
            default:
                return ($str);
        }
    }
    
    /**
     *
     * preUnformat the string for unformatter
     * function.
     * 151.31 B -- 234.23 k -- 234.23 M  --  $151.32 k  -- 0.22%  --  1200%  -- 0.55% p.a.  
     * @param string $str
     * @return type
     *
     */
    static function preUnformat($str){
        $suffix = ['B','k','M','00%','%','% p.a.'];
        $result = 0;
        foreach($suffix as $format){
            if(strpos($str,'$')!==false){
                $str = str_replace('$','',$str);
            }
    
            if(strpos($str,$format)!==false){
                $result = self::unformatter($str,$format);
                break;
            }
        }
        return $result;
    }
    
    /* unformatDate
     * 5.34  -- Jun 12, 2010 -- 06/12/10
     * */
    static function unformatDate($date){
        if(is_numeric($date)){
            $date = time()-$date*365*24*60*60;
            return date('Y-m-d',$date);
        }else if(is_string($date)){
            return date('Y-m-d',strtotime($date));
        }
    }

}

?>