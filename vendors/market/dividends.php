<?php

Yii::import('application.vendors.*');
require_once('market/globals.php');
require_once('market/dates.php');

class dividends {

    public $dbH;
    public $ticker;
    public $xml;
    public $divs;
    public $start;
    public $end;


    /**
     * 
     * The dividends class manages the various distributions for a security.
     * 
     * @param string    $ticker
     * @param DBHandle  $dbH
     * 
     * @return dividends A new dividnds object.
     * 
     */
    public function __construct($ticker, $dbH) {
        $this->dbH = $dbH;
        $this->ticker = $ticker;
        $this->divs = null;
        $this->xml = null;
    }


    /**
     * 
     * 
     * @global type $ERROR
     * @param type $start
     * @param type $end
     * @return type
     * 
     */
    public function setDateRange($start, $end) {
        global $ERROR;

        if ($start > $end) {
            return ($ERROR);
        }

        $this->start = dateClean($start);
        $this->end = dateClean($end);

        return (true);
    }


    public function parseDivs() {
        if(!isset($this->xml->GetCashDividendHistoryResult->Dividends->Dividend))return false;
        $divArr = $this->xml->GetCashDividendHistoryResult->Dividends->Dividend;
        
        if ($divArr == null)
            return ($ERROR);

        $this->divs = array();
        for ($i = 0; $i < count($divArr); $i++) {

            $d = $divArr[$i];
            $divPayment["Currency"] = $d->Currency;

            $divPayment["code"] = $d->Code;
            $divPayment["type"] = $d->Type;
            $divPayment["frequency"] = $d->PaymentFrequency;

            $declaredDate = $d->DeclaredDate;
            $divPayment["declaredDate"] = dateMDYDateToMktime($declaredDate);

            $recordDate = $d->RecordDate;
            $divPayment["recordDate"] = dateMDYDateToMktime($recordDate);

            $exDate = $d->ExDate;
            $divPayment["exDate"] = dateMDYDateToMktime($exDate);

            $payDate = $d->PayDate;
            $divPayment["payDate"] = dateMDYDateToMktime($payDate);

            $exDate = $d->ExDate;
            $divPayment["exDate"] = dateMDYDateToMktime($exDate);

            $amount = $d->DividendAmount;
            $divPayment["amount"] = $amount;

            $this->divs = $divPayment;
        }
        return true;
    }


    /**
     * 
     * @return type
     */
    public function loadDivs() {
        global $ERROR;

        if ($this->getXIgniteDivs() === $ERROR) {
            return ($ERROR);
        } else {
            return $this->parseDivs();
        }
    }


    /**
     * 
     * @return type
     * 
     */
    public function getXIgniteDivs() {
        // define the SOAP client using the url for the service
        $client = new soapclient('http://www.xignite.com/xGlobalHistorical.asmx?WSDL');

        // create an array of parameters 
        $param = array(
            "Identifier" => $this->ticker,
            "IdentifierType" => "Symbol",
            "StartDate" => date("m/d/Y", $this->start),
            "EndDate" => date("m/d/Y", $this->end));

        // add authentication info
        $xignite_header = new SoapHeader('http://www.xignite.com/services/', "Header", 
                                            array("Username" => "B133E28DAD8943DA8E6AFE62CAF2021F")
                                        );
        $client->__setSoapHeaders(array($xignite_header));

        // call the service, passing the parameters and the name of the operation 
        $this->xml = $client->GetCashDividendHistory($param);
        // assess the results 
        if (is_soap_fault($this->xml)) {
            return ($ERROR);
        } else {
            return (true);
        }
    }


    /**
     *
     * Debugging aid to print a single dividend entry.
     * 
     */
    public function printDividends() {
        if ($this->divs == null) {
            print ("No Dividends<br>");
        } else {
            print ( "Record Date" . " " . "Pay Date" . " " . "Ex-Date" . " " . "Amount" . " " . "Frequency" . " " . "Type" . "<br>");
            foreach ($this->divs as $d) {
                $this->printDividend($d);
            }
        }
    }


    /**
     * 
     * Debugging aid to print a single dividend entry.
     * 
     * @param DivEntry  $d 
     * 
     */
    public function printDividend($d) {

        $type = ($d['type'] != null) ? $d['type'] : 0;
        $freq = ($d['frequency'] != null) ? $d['frequency'] : 0;
        $decl = ($d['declaredDate'] != null) ? date("Y-m-d", $d['declaredDate']) : " * ";
        $rec = ($d['recordDate'] != null) ? date("Y-m-d", $d['recordDate']) : " * ";
        $pay = ($d['payDate'] != null) ? date("Y-m-d", $d['payDate']) : " * ";
        $ex = ($d['exDate'] != null) ? date("Y-m-d", $d['exDate']) : " * ";
        $amt = ($d['amount'] != null) ? round($d['amount'], 4) : 0;
        print ( $rec . " " . $pay . " " . $ex . " " . $amt . " " . $freq . " " . $type);

//        if (array_key_exists("multiplier", $d))
//            print ($d["multiplier"] . " ");
//
//        if (array_key_exists("afterTaxMult", $d))
//            print ($d["afterTaxMult"] . " ");

        print ("<br>");
    }
    
/*     public function get_dividends($ticker){
         //$ticker = getURLParameter($ticker);
         $divs = new dividends($ticker, null);
         $divs->setDateRange(dateDBDateToMktime("2000-01-01"), dateDBDateToMktime("2015-10-01"));
         $divs->loadDivs();
         //$divs->printDividends();
         //return $divs->xml->GetCashDividendHistoryResult->Dividends->Dividend;
         return $this->divs;
    } */

}

/**
 *   Test and verify functionality of above code.
 */

    

?>