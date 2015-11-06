<?php


/**
 * 
 * @global type $ERROR
 * @param type $dbH
 * @param type $query
 * @return type
 * 
 */
function dbExecuteQuery($dbH, $query) {
    global $ERROR;

    if ($results = mysqli_query($dbH, $query)) {
        return ($results);
    } else {
        print ("<br>" . mysqli_error($dbH));
        return ($ERROR);
    }
}


/**
 * 
 * Opens a connection to the database
 * 
 * @return type
 * 
 */
function dbOpen() {
    include ("dbconfig.php");

    $done = false;
    $attempts = 0;
    while (!$done) {
        $dbH = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (mysqli_connect_error()) {
            logReport("Could not connect: " . mysqli_error($dbH));
            $attempts++;

            if ($attempts > 10) {
                logReport("Could not connect after $attempts attempts: " . mysqli_error($dbH));
                return (null);
            }
        } else {
            $done = true;
        }
    }

    return ($dbH);
}


/**
 * Close the database 
 * 
 * @param   type $dbH Handle to the database
 * @return  <none>
 */
function dbClose($dbH) {
    mysqli_close($dbH);
}

/**
 * 
 * Get all available tickers in FundProfiles table
 * 
 * @param   type    $dbH Handle to the database
 * @return  type    Returns array of tickers, if available, null otherwise
 * 
 */

function dbGetTickers($dbH) {
    global $ERROR;

    $sqlQuery = "SELECT ticker FROM FundProfiles ORDER BY ticker ASC";
    $sqlResults = dbExecuteQuery($dbH, $sqlQuery);

    if ($sqlResults === $ERROR) {
        logReport ("dbGetTickers: Unable to get data from FundProfiles:" . mysqli_error($dbH));
        return (false);
    }

    while ($row = mysqli_fetch_array($sqlResults)) {
        $tick = strtoupper(trim($row['ticker']));
        $tickers[] = $tick;
    }

    return ($tickers);
}

/**
 * 
 * Get all available tickers in FundProfiles table
 * 
 * @param   type    $dbH        Handle to the database
 *          type    $ticker     Ticker to identify the inceptionDate
 * 
 * @return  type                Returns array of tickers, if available, null otherwise
 * 
 */

function dbGetInceptionDate ($dbH, $ticker) {
    global $ERROR;

    $sqlQuery = "SELECT firstTradeDate FROM FundProfiles WHERE ticker='$ticker'";
    $sqlResults = dbExecuteQuery($dbH, $sqlQuery);

    if ($sqlResults === $ERROR) {
        logReport ("dbInceptionDate: Unable to get data firstTradeDate from FundProfiles:" . mysqli_error($dbH));
        return (false);
    }

    while ($row = mysqli_fetch_array($sqlResults)) {
        $inceptDate = dateDBDateToMktime($row['firstTradeDate']);
    }

    return ($inceptDate);
}



?>