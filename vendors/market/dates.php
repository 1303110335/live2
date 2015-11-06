<?php
Yii::import('application.vendors.market.*');
require_once('market/calendar.php');
/**
 * A series of functions to deal with dates, date formats and date arithmetic
 *
 */


/**
 * Convert a date formatted as YYYY-MM-DD to UTCTime
 * 
 * @param   string  $dbDate A date string formatted as YYYY-MM-DD
 * 
 * @return  UTCTime Returns the UTC time equivalent of $dbDate
 */
function dateDBDateToMktime($dbDate) {
    $year = substr($dbDate, 0, 4);
    $month = substr($dbDate, 5, 2);
    $day = substr($dbDate, 8, 2);

    return (mktime(0, 0, 0, (int) $month, (int) $day, (int) $year));
}


/**
 * Convert a date formatted in Mktime to DBDate
 * 
 */
function dateMktimeToDBdate($mktime) {
    return (date("Y-m-d", $mktime));
}


/**
 * Convert 12/31/2002 or 12-31-2002 => UTC Time
 * 
 * @param string $mdyDate
 * @return UTCTime
 */
function dateMDYDateToMktime($mdyDate) {
    if (strpos($mdyDate, "-"))
        $mdy = explode("-", $mdyDate);
    else
        $mdy = explode("/", $mdyDate);

    if (count($mdy) == 3) {
        $month = $mdy[0];
        $day = $mdy[1];
        $year = $mdy[2];
        return (mktime(0, 0, 0, (int) $month, (int) $day, (int) $year));
    } else {
        return 0;
    }
}


/**
 *  Convert 12/31/2002 => 2002/12/31
 *
 * @param string    $mdy
 * @return string
 */
function dateMDYToYMD($mdy) {
    $utc = dateMDYDateToMktime($mdy);
    $ymd = date("Y-m-d", $utc);
    return ($ymd);
}


/**
 * Return absolute value of difference between to UTC times
 * 
 * @param UTCTime $mktime
 * @return string
 */
function dateMktimeToMDY($mktime) {
    return (date("m/d/Y", $mktime));
}


/**
 *  Return absolute value of difference between to UTC times
 * 
 * @param   UTCTime   $d1 
 * @param   UTCTime   $d2
 * @return  UTCTime Returns the absolute value of the difference in UTCTime
 * 
 */
function dateDiffUTC($d1, $d2) {
    return (($d1 > $d2) ? ($d1 - $d2) : ($d2 - $d1));
}


/**
 * 
 * Check whether dates $d1 and $d2 are referencing the same calendar
 * date.
 * 
 * @param   UTCTime   $d1 
 * @param   UTCTime   $d2
 * @return  bool    Returns true if same date, false otherwise
 * 
 */
function dateSameDay($d1, $d2) {
    return ((dateClean($d1) == dateClean($d2)) ? true : false);
}


/**
 * Check to see if UTCTime $d1 is during market hours (between 9:30AM and 4:00PM).
 * 
 * @param UTCTime $d1
 * @return bool
 */
function dateDuringMarketHours($d1) {
    $hour = date("G", $d1);
    $mins = date("i", $d1);

    if ((($hour == 9) && ($mins >= 30)) ||
            ($hour >= 10)) {
        if ((($hour == 16) && ($mins == 0)) ||
                ($hour < 16)) {
            return (true);
        }
    }

    return (false);
}


/**
 * Check to see if UTCTime $d1 is during pre-market hours (between 6:00AM and 9:30AM).
 * 
 * @param UTCTime $d1
 * @return bool
 */
function dateDuringPreMarketHours($d1) {
    $hour = date("G", $d1);
    $mins = date("i", $d1);

    if (($hour >= 6) && (($hour <= 9) && ($mins < 30))) {
        return (true);
    }

    return (false);
}


/**
 * Check to see if UTCTime $d1 is during after market hours (between 4:00PM and 8:00PM).
 * 
 * @param UTCTime $d1
 * @return bool
 */
function dateDuringAfterMarketHours($d1) {
    $hour = date("G", $d1);
    $mins = date("i", $d1);

    if (($hour >= 16) && ($hour <= 20)) {
        return (true);
    } else {
        return (false);
    }
}


/**
 * 
 * Find the index within a $calendar, typically $TRADING_DAYS, $MONTH_END_DAYS,
 * or QTR_END_DAYS, etc., that houses $target.  If $target is not found within 
 * $calendar, will return the nearest if $returnPrevious is set to true (default).
 * 
 * @param   UTCTime   $target           Target date being sought 
 * @param   array     $calendar         Applicable calendar
 * @param   bool      $returnPrevious   Boolean to indicate whether previous dat 
 *                                      should be returned.
 * 
 * @return  int Returns the index within the $calendar housing $target
 * 
 */
function dateFindIndex($target, $calendar, $returnPrevious = true) {
    global $ERROR;

    $index = dateBinarySearch($target, $calendar, 0, count($calendar) - 1, $returnPrevious);

    if ($index === $ERROR)
        return ($ERROR);  // ERROR condition.  Date not found in calendar.
    elseif ($target == dateDBDateToMktime($calendar[$index]))
        return ($index);
    elseif ($returnPrevious) {
        if ($index > 0) {
            return ($index - 1);
        } else {
            return ($ERROR);
        }
    }
}


/**
 * 
 * Find the date nearest to target date.  
 * 
 * Finds the date specified by $target within the $calendar (default is $TRADING_DAYS) and
 * returns a date that $steps (positive or negative) away from $target.
 * 
 * @param UTCType   $target     Base date
 * @param array     $calendar   Calendar to use (passed by REFERENCE) (default is $TRADING_DAYS) 
 * @param int       $step       Additional increments/decrements from found date for positive/negative $steps
 * 
 * @return UTCType  Returns the date that is nearest $target.
 * 
 */
function dateFindNearest($target, &$calendar, $step = 1) {
    global $TRADING_DAYS;
    global $ERROR;

    $cal = (!$calendar) ? $TRADING_DAYS : $calendar;
    if (!$target)
        return ($ERROR);

    $index = dateFindIndex($target, $cal, true);

    if ($index === $ERROR) {
        return ($ERROR);
    } else {
        return (dateDBDateToMktime($cal[$index + $step]));
    }
}


/**
 * 
 * Find the nearest month-end date to today
 * 
 * @return Returns the nearest month-end date to today; ERROR, if otherwise
 * 
 */
function dateNearestMonthEnd() {
    global $MONTH_END_DAYS;

    $now = time();
    $today = dateClean($now);
    return (dateFindNearest($today, $MONTH_END_DAYS, 0));
}


/**
 * 
 * Find the nearest trading day that is already closed
 * 
 * @global type $TRADING_DAYS
 * @return type
 * 
 */
function dateNearestPastBusinessDay() {
    global $TRADING_DAYS;

    $target = dateClean(time());

    if (dateIsTradingDay($target))
        return (dateFindNearest($target, $calendar, -1));
    else
        return (dateFindNearest($target, $calendar, 0));
}


/**
 * 
 * Finds a trading day that is $n days away from $target.
 * 
 * @param type $target
 * @param type $n
 * 
 */
function dateTradingDaysAway($target, $n) {
    global $TRADING_DAYS;
    global $ERROR;

    $inx = dateFindIndex($target, $TRADING_DAYS);
    $nAway = $inx + $n;

    if (($nAway < 0) || ($nAway > count($TRADING_DAYS))) {
        return ($ERROR);
    } else {
        return (dateDBDateToMktime($TRADING_DAYS[$nAway]));
    }
}


/**
 * Check to see if today is a valid trading day otherwise 
 * return previous trading day.
 * 
 * @global type $TRADING_DAYS
 * @return UTCTime
 * 
 */
function dateMostRecentTradingDay() {
    global $TRADING_DAYS;

    $target = dateClean(time());
    if (dateIsTradingDay($target))
        return ($target);
    else
        return (dateFindNearest($target, $calendar, -1));
}


/**
 * Computes a period begining at the end of the previous month through
 * $endDate (if null, defaults to the most recent trading day).
 * 
 * @global  type        $MONTH_END_DAYS
 * @param   UTCTime     $endDate
 * @return  array       Return an array containing three keys: tenor, start and end.
 */
function dateMTD($endDate = null) {
    global $MONTH_END_DAYS;

    return (dateDefineTenor("MTD", 0, $endDate, $MONTH_END_DAYS));
}


/**
 * Computes a period begining at the end of the previous year through
 * $endDate (if null, defaults to the most recent trading day.
 * 
 * @global  type        $QTR_END_DAYS
 * @param   UTCTime     $endDate
 * @return  array       Return an array containing three keys: tenor, start and end.
 */
function dateQTD($endDate = null) {
    global $QTR_END_DAYS;

    return (dateDefineTenor("QTD", 0, $endDate, $QTR_END_DAYS));
}


/**
 * Computes a period begining at the end of the previous year through
 * $endDate (if null, defaults to the most recent trading day.
 * 
 * @global type $YEAR_END_DAYS
 * @param UTCTime $endDate
 * @return array Return an array containing three keys: tenor, start and end.
 */
function dateYTD($endDate = null) {
    global $YEAR_END_DAYS;

    return (dateDefineTenor("YTD", 0, $endDate, $YEAR_END_DAYS));
}


/**
 * 
 * Will seek to define a period within the specified calendar 
 * ($cal, default is $MONTH_END_DAYS) that ends on $endDate and begins
 * $steps prior to $endDate.
 * 
 * @param   string  $tenor      Typically, a string that describes the period of time (1M, 3M, etc).
 * @param   int     $step       A positive integer that defines the number of steps to traverse
 *                              back.
 * @param   UTCTime $endDate    End of the period date (defaults to current date)
 * @param   array   $cal        Optional calander (from calendar.php or alternate source)
 * 
 * @return array Return an array containing three keys: tenor, start and end.
 * 
 */
function dateDefineTenor($tenor, $step, $endDate = null, $cal = null) {
    global $MONTH_END_DAYS;
    global $ERROR;

    if (!$cal)
        $cal = $MONTH_END_DAYS;

    $end = ($endDate == null) ? dateMostRecentTradingDay() : dateClean($endDate);

    $start = dateFindNearest($end, $cal, -$step);
    if ($start == $ERROR) {
        return ($ERROR);
    } else {
        $date['tenor'] = $tenor;
        $date['dbField'] = "p" . $tenor;
        $date['start'] = $start;
        $date['end'] = $end;
        return ($date);
    }
}


/**
 * 
 * One of the tools to build an array of calendar periods, in this case the period
 * is since year to date ($origin)
 * 
 * @param   UTCTime     $origin     First recognized date for the calender (no start or end date can be defined as being
 *                                  prior to the $origin)
 * @param   UTCTime     $endDate    Date in which the various periods end (can be adjusted based on $snap)
 * @param   bool        $snap       Snap the $endDate to the $MONTH_END_DATE
 * 
 * @return  array   Returns an array of periods (only one item in this case), where each period 
 *                  has a three defined keys (tenor, start and end)
 * 
 */
function dateBuildPeriodYTD($origin, $endDate, $snap) {
    global $MONTH_END_DAYS;

    $calArr = array();
    $endDate = ($snap) ? dateFindNearest($endDate, $MONTH_END_DAYS, 0) : $endDate;
    $d = dateYTD($endDate);
    if ($origin <= $d['start']) {
        $calArr[] = $d;
    }
    return ($calArr);
}


/**
 * 
 * One of the tools to build an array of calendar periods, in this case the period
 * is Since Inception ($origin)
 * 
 * @param   UTCTime     $origin     First recognized date for the calender (no start or end date can be defined as being
 *                                  prior to the $origin)
 * @param   UTCTime     $endDate    Date in which the various periods end (can be adjusted based on $snap)
 * @param   bool        $snap       Snap the $endDate to the $MONTH_END_DATE
 * 
 * @return  array   Returns an array of periods (only one item in this case), where each period 
 *                  has a three defined keys (tenor, start and end)
 * 
 */
function dateBuildPeriodSI($origin, $endDate, $snap) {
    global $MONTH_END_DAYS;

    $calArr = array();
    if ($snap)
        $endDate = dateFindNearest($endDate, $MONTH_END_DAYS, 0);

    $d['tenor'] = "SinceInception";
    $d['start'] = $origin;
    $d['end'] = $endDate;
    $d['dbField'] = "p" . "SinceInception";

    $calArr[] = $d;

    return ($calArr);
}


/**
 * 
 * Tool to build an array of annual calendar periods, with each period defined as an array 
 * containing three keys: tenor, start and end).
 * 
 * dateBuildPeriodsFixedYears () builds an array of fixed-year periods.  Takes as input an
 * array of calendar years (e.g. 2010, 2011, 2012, 2013...) and creates an array of periods
 * that begin and end at the start and end of the year, respectively.  For periods where the
 * period is only a partial year, the tenor is marked with an *. 
 * 
 * @param   UTCTime     $origin     First recognized date for the calender (no start or end date can be defined as being
 *                                  prior to the $origin)
 * @param   UTCTime     $endDate    Last recognized date for the calender (no start or end date can be defined as being
 *                                  after the $endDate)
 * @param   array       $fixedYears An array of integers for which periods are being computed, defined as e.g. [2010, 2011, ...]
 * @return  array   Returns an array of periods, where each period has a three defined keys (tenor, start and end)
 * 
 */
function dateBuildPeriodsFixedYears($origin, $endDate, $fixedYears) {
    global $YEAR_END_DAYS;

    $calArr = array();

    for ($i = 0; $i < count($fixedYears); $i++) {
        $yearEndStr = $fixedYears[$i] . "-12-31";
        $yearEnd = dateDBDateToMktime($yearEndStr);

        $d['end'] = dateFindNearest($yearEnd, $YEAR_END_DAYS, 0);
        $d['start'] = dateFindNearest($d['end'], $YEAR_END_DAYS, -1);
        $d['tenor'] = $fixedYears[$i];
        $d['dbField'] = "p" . $fixedYears[$i];


        // period ends before we begin, do nothing
        if ($d['end'] < $origin)
            continue;

        // if period starts before $origin, adjust start date
        if ($d['start'] < $origin) {
            $d['start'] = $origin;
            $d['tenor'] = $fixedYears[$i] . "*";
            $d['dbField'] = "p" . $fixedYears[$i];
        }

        // period starts after end date, do nothing 
        if ($d['start'] > $endDate)
            continue;

        // if period ends after $endDate, adjust end date
        if ($d['end'] > $endDate) {
            $d['end'] = $endDate;
            $d['tenor'] = $fixedYears[$i] . "*";
            $d['dbField'] = "p" . $fixedYears[$i];
        }

        $calArr[] = $d;
    }

    return ($calArr);
}


/**
 * 
 * Tool to build an array of various calendar periods, with each period defined as an array 
 * containing three keys: tenor, start and end).
 * 
 * dateBuildPeriods () builds an array of periods as defined by the various settings and parameters.  In general,
 * the function takes as input an array for weeks, months, quarters, years, etc. and based on the 
 * contents of these arrays builds periods (tenor, start, and end) that are associated with these various arrays. 
 * 
 * 
 * @param   UTCTime     $origin     First recognized date for the calender (no start or end date can be defined as being
 *                                  prior to the $origin)
 * @param   UTCTime     $endDate    Date in which the various periods end (can be adjusted based on $snap)
 * @param   bool        $snap       Snap the $endDate to the $MONTH_END_DATE
 * @param   array       $periods    An array of integers for which periods are being computed
 * @param   array       $cal        Applicable calender (typically from calendar.php)
 * @param   char        $marker     Letter indicating Weeks ("W"), Month ("M"), Year ("Y)
 * 
 * @return  array       Returns an array of periods, where each period has a three defined keys (tenor, start and end)
 * 
 */
function dateBuildPeriods($origin, $endDate = null, $snap = true,
        $periods = null, &$cal, $marker) {

    global $MONTH_END_DAYS;

    $calArr = array();
    $endDate = (!$endDate) ? dateClean(dateMostRecentTradingDay()) : $endDate;
    $endDate = ($snap == true) ? dateFindNearest($endDate, $MONTH_END_DAYS, 0) : $endDate;


    for ($i = 0; $i < count($periods); $i++) {

        $tenor = $periods[$i] . $marker;

        if ($snap) {
            $d = dateDefineTenor($tenor, $periods[$i], $endDate, $cal);
        } else {
            switch ($marker) {
                case "W":
                    $priors = "-" . $periods[$i] . " weeks";
                    break;

                case "M":
                    $priors = "-" . $periods[$i] . " months";
                    break;

                case "Y":
                    $mStr = $periods[$i];
                    $priors = "-" . $mStr . " years";
                    break;

                default:
                    return ($ERROR);
            }
            $nMonthsPrior = strtotime($priors, strtotime(date("Y-m-d", $endDate)));
            $d['tenor'] = $tenor;
            $d['dbField'] = "p" . $tenor;
            $d['start'] = dateFindNearest($nMonthsPrior, $TRADING_DAYS, 0);
            $d['end'] = $endDate;
        }

        if ($d['start'] >= $origin)
            $calArr[] = $d;
    }

    return ($calArr);
}


/**
 * 
 * @param type $inceptDate
 * @param type $endDate
 * 
 */
function dateDefinedPeriodsFrom($inceptDate, $endDate, &$cal) {

    $done = false;
    $mPeriods = array();
    $periodStart = $inceptDate;
    $sInx = dateFindIndex($inceptDate, $cal, true);
    if ($periodStart >= dateDBDateToMktime($cal[$sInx])) {
        $sInx++;
    }

    while (!$done) {
        $d['tenor'] = "1D";
        $d['start'] = $periodStart;
        $d['end'] = dateDBDateToMktime($cal[$sInx]);

        if ($endDate >= dateDBDateToMktime($cal[$sInx])) {
            $periodStart = $d['end'];
            $sInx ++;
            $mPeriods[] = $d;
        } else {
            $done = true;
        }
    }

    return ($mPeriods);
}


/**
 * 
 * @param type $inceptDate
 * @param type $endDate
 * 
 */
function dateDailyPeriodsFrom($inceptDate, $endDate) {
    global $TRADING_DAYS;

    return (dateDefinedPeriodsFrom($inceptDate, $endDate, $TRADING_DAYS));
}


/**
 * 
 * @global type $TRADING_DAYS
 * @param type $inceptDate
 * @param type $endDate
 * @return type
 * 
 */
function dateWeeklyPeriodsFrom($inceptDate, $endDate) {
    global $WEEK_END_DAYS;

    return (dateDefinedPeriodsFrom($inceptDate, $endDate, $WEEK_END_DAYS));
}


/**
 * 
 * Build a series of periods beginning rom $inceptDate through $endDate
 * 
 * @param type $inceptDate
 */
function dateMonthlyPeriodsFrom($inceptDate, $endDate) {
    global $MONTH_END_DAYS;

    return (dateDefinedPeriodsFrom($inceptDate, $MONTH_END_DAYS, $MONTH_END_DAYS));
}


/**
 * 
 * Build a series of periods beginning rom $inceptDate through $endDate
 * 
 * @param type $inceptDate
 * 
 */
function dateQuarterlyPeriodsFrom($inceptDate, $endDate) {
    global $QTR_END_DAYS;
    return (dateDefinedPeriodsFrom($inceptDate, $endDate, $QTR_END_DAYS));
}


/**
 * 
 * Build a series of periods beginning rom $inceptDate through $endDate
 * 
 * @param type $inceptDate
 * 
 */
function dateAnnualPeriodsFrom($inceptDate, $endDate) {
    global $YEAR_END_DAYS;
    return (dateDefinedPeriodsFrom($inceptDate, $endDate, $YEAR_END_DAYS));
}


/**
 * 
 * Add or subtract a specified number of days ($numDays) to a given date ($startDate)
 * 
 * The function will add the number of days specified in $numDays to $startDate and 
 * will return a new date.  If $numDays is negative, the function will subtract specified
 * number of days.
 * 
 * @param   UTCTime     $startDate      Base date
 * @param   int         $numDays        Number of days to add/subtract from $startDate
 * 
 * @return  UTCTime     Returns a new date that is $numDays shifted, either positively or negatively,
 *                      from $startDate
 * 
 */
function dateAddDays($startDate, $numDays) {
    $secondsInADay = 60 * 60 * 24;

    return ($startDate + ($numDays * $secondsInADay));
}


/**
 * 
 * Returns the positive difference in days between two dates ($d1and $d2)
 * 
 * @param UTCTime $d1
 * @param UTCTime $d2
 * 
 * @return int  Number of days between $d1 and $d2 (return value is 
 *              always positive)
 */
function dateDiff($d1, $d2) {
    $one = dateClean(
            $d1);
    $two = dateClean($d2);
    if ($one < $two)
        $diff = $two - $one;
    else
        $diff = $one - $two;

    return round($diff / (60 * 60 * 24));
}


/**
 * Return number of trading days between $startDate and $endDate.
 * 
 * Count the number of days between the start date ($startDate)
 * and end date ($endDate).  By default, the function uses $TRADING_DAYS
 * calendar, but will also accept as an optional parameter an alternate calendar.
 * Optionally takes as input a dateArr (which should typically be empty) and will 
 * fill this array with series of trading days between start and end dates.
 * 
 * @param   UTCTime     $startDate
 * @param   UTCTime     $endDate
 * @param   array       $cal (optional calendar but default is $TRADING_DAYS)
 * @param   array       $dateArr (if an empty array is passed by REFERENCE, 
 *                      function will fill array with dates) 
 * 
 * @return int  Returns number of trading days between start and end dates. Optionally, 
 *              will also complete an optionally passed dateArray with trading days
 *              between start and end dates.
 */
function dateTradingDatesBetween($startDate, $endDate, $cal = null,
        &$dateArr = null) {
    global $ERROR;
    global $TRADING_DAYS;

    if ($cal == null) {
        $cal = $TRADING_DAYS;
    }

    if ($endDate < $startDate) {
        $tempDate = $startDate;
        $startDate = $endDate;
        $endDate = $tempDate;
    }

    $sIndex = dateFindIndex($startDate, $cal);
    $eIndex = dateFindIndex($endDate, $cal);

    if (($sIndex === $ERROR) || ($eIndex === $ERROR))
        return ($ERROR );
    if ($dateArr) {
        for ($i = 0; $i <= ($eIndex - $sIndex ); $i++) {
            $dateArr[] = dateDBDateToMktime($cal[$i + $sIndex]);
        }
    }

    return ($eIndex - $sIndex + 1);
}


/**
 *  Search recursively for a specified date ($needle) in a given calendar ($haystack).
 *  
 *  Return the location within a specified calendar ($haystack) containing 
 *  the sought after date ($needle).  Search is done recursively and $haystack and 
 *  $needle are passed by reference to reduce overhead.
 * 
 * @param  UTCTime  $n             Date being sought
 * @param  array    $haystack      Calendar array as specified in calender.php (Passed by REFERENCE)
 * @param  int      $start         Starting index within haystack
 * @param  int      $end           Ending index within haystack
 * @param  bool     $approximate   Boolean indicator to find closest match, if false than need exact match
 * 
 * @return int Returns an index within the calendar array ($haystack) containing sought after date ($needle)
 *              If $needle not found, returns $ERROR
 */
function dateBinarySearch($n, &$haystack, $start, $end, $approximate = true) {
    global $ERROR;

    if ($end < $start) {
        return (($approximate == true ) ? $start : $ERROR);
    }

    $mid = (int) (($end - $start) / 2) + $start;

    $needle = dateClean($n);
    $currentDate = dateClean(dateDBDateToMktime($haystack[$mid]));

    if ($currentDate > $needle) {
        return ( dateBinarySearch($needle, $haystack, $start, $mid - 1, $approximate));
    } else if ($currentDate < $needle) {
        return ( dateBinarySearch($needle, $haystack, $mid + 1, $end, $approximate));
    } else {
        return ($mid);
    }
}


/**
 * Check if specified date ($date) is a trading day as defined in 
 * $TRADING DAYS.
 * 
 * Search $TRADING_DAYS calendar array for specified date ($date). If found
 * return true, false otherwise.
 * 
 * @param   UTCDate     $date
 * @return  bool        true if $date is a trading day and 
 *                      false otherwise.
 */
function dateIsTradingDay($date) {
    global $TRADING_DAYS;
    global $ERROR;

    $searchDate = dateClean($date);
    $tradingDay = dateFindIndex($searchDate, $TRADING_DAYS, $returnPrevious = false);
    if ($tradingDay === $ERROR) {
        return (false);
    } else {
        return (true);
    }
}


/**
 * Eliminate any hours, mins and seconds in date ($date)
 * 
 * Elimnate any hours, mins and seconds in date ($date).  Typically used in date 
 * calculations, where inclusion of stray hours, mins and seconds can create 
 * unexpected calculation errors/offsets.
 * 
 * @param   UTCTime     $date
 * @return  UTCTime
 */
function dateClean($date) {
    return (dateDbDateToMktime(date("Y-m-d", $date)));
}


/**
 * Debugging aid to print a time series array containing elements, which each contain
 * a tenor, start date, end date, and a possible return.
 * 
 * @param   array   $d  an array containing elements with each element in turn containing
 *                      a tenor, start date, end date and a possible return value.
 * 
 * @return null
 */
function datePrintArray($d) {
    if ($d) {


        print ("<br>");
        foreach ($d as $date)
            datePrint($date);
        print ("<br>");
    } else {
        print ("<br> No dates <br>");
    }
}


/**
 * Debugging aid to print a period containing tenor, start date, end date, 
 * and a possible return.
 * 
 * @param   array   $d  an array containing tenor, start date, end date and
 *                      a possible return value.
 * 
 * @return null
 */
function datePrint($d) {
    $keys = array_keys($d);
    $t = array_key_exists("tenor", $d) ? $d['tenor'] : "! TENOR";
    if (array_key_exists("dbField", $d)) {
        $dbField = $d['dbField'];
    } else {
        $dbField = "";
    } if (array_key_exists("start", $d)) {
        $s = date("Y-m-d", $d['start']);
    } else {
        $s = "! START";
    } if (array_key_exists("end", $d)) {
        $e = date("Y-m-d", $d['end']);
    } else {
        $e = "! END";
    }

    if (array_key_exists("return", $d)) {
        $r = $d['return'];
    } else {
        $r = "N/A";
    }

    print ("$t ($dbField): $s...$e


, return = " . $r . "<br>");
}


/**
 * 
 * @param type $periods
 */ function datePrintPeriodReturns($periods) {
    foreach ($periods as $d) {
        if (array_key_exists("start", $d)) {
            $s = date("Y-m-d", $d['start']);
        } else {
            $s = "! START";
        }

        if (array_key_exists("end", $d)) {
            $e = date("Y-m-d", $d['end']);
        } else {
            $e = "! END";
        }

        if (array_key_exists("return", $d)) {
            $r = $d['return'];
        } else {
            $r = "N/A";
        }

        print ("$s, $e, " . formatter($r, "100%00", 4) . "<br>");
    }
}


/**
 * Simple utility to print the time 
 * 
 * @param UTCTime $mktime
 */
function datePrintMktime($mktime) {
    print (date("Y-m-d", $mktime));
}


/**
 *  Stand-alone utility to test the various date functions
 *  
 */
function dateVerifyFunctions() {
    global $TRADING_DAYS;
    global $ERROR;

    $arr = null;

    $months = [ 1, 3, 6];
    $years = [ 1, 3, 5, 7, 10];
    $weeks = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    $fixedYears = [ 2010, 2011, 2012, 2013, 2014, 2015];
    $origin = dateDBDateToMktime("2010-06-23");
    $endDate = dateDBDateToMktime("2015-09-21");

    $siArr = dateBuildPeriodSI($origin, $endDate, false);
    $ytdArr = dateBuildPeriodYTD($origin, $endDate, false);
    $weeksArr = dateBuildPeriods($origin, $endDate, false, $weeks, $WEEK_END_DAYS, "W");
    $monthsArr = dateBuildPeriods($origin, $endDate, false, $months, $MONTH_END_DAYS, "M");
    $yearsArr = dateBuildPeriods($origin, $endDate, false, $years, $YEAR_END_DAYS, "Y");
    $fixedYearsArr = dateBuildPeriodsFixedYears($origin, $endDate, $fixedYears);
    $arr = array_merge($siArr, $ytdArr, $weeksArr, $monthsArr, $ytdArr, $yearsArr, $fixedYearsArr);

    datePrintArray($arr);

    print ("<br>");
    datePrint($ytdArr[0]);
    $numDays = dateDiff($ytdArr[0]['start'], $ytdArr[0]['end']);
    print ("<br>$numDays");
}

?>