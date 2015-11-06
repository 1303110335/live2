<?php
    /*
     SimpleXMLElement Object
     (
         [Record] => SimpleXMLElement Object
         (
             [Sym] => HAP
             [Desc] => MARKET VECTORS NATURAL RESOURC
             [Last] => 30.13
             [Change] => 0.37
             [Previous] => 29.76
             [Open] => 29.76
             [High] => 30.33
             [Low] => 29.7
             [Volume] => 35394
             [Week52High] => 37.3299
             [Week52Low] => 26.18
             [Bid] => 28.66
             [Ask] => SimpleXMLElement Object
             (
             )
             [Timestamp] => 11/3/2015 15:59:51
         )
     )
     */
    //echo $xml->Record->Sym;
    function get_obj_from_xml($ticker){
        $ch = curl_init('http://www.thefinancials.com/feeds/getQuoteXML.asp?pid=lft&type=quotes&fields=Previous,Open,High,Low,AverageVolume,Volume,Week52High,Week52Low,Bid,Ask&s='.$ticker);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $str = curl_exec($ch);
        $xml  =  simplexml_load_string ( $str );
        curl_close($ch);
        return $xml->Record;
    }
    
    function get_all_date($ticker){
        echo $ticker;exit;
        $ticker = getURLParameter($ticker);
        $divs = new dividends($ticker, null);
        $divs->setDateRange(dateDBDateToMktime("2000-01-01"), dateDBDateToMktime("2015-10-01"));
        $divs->loadDivs();
        return $divs;
    }
	
?> 