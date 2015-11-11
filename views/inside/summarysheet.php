
<?php $this->header('Fund Viewer','In-depth summary of selected ETF','ETF Summary Sheet');?>
<script type="text/javascript" src="/js/etf/summary.js"></script>
<!-- iShare Sec -->
<?php $this->renderPartial('/common/iShare',array('res'=>$res));?>

<?php if(!empty($res)) $this->renderPartial('/common/investment',array('res'=>$res));
      else $this->renderPartial('/common/investment');
?>

<!-- Distributions -->
<div class="keyfacts_sec" style="width:70%;margin:0;">
    <h2>Distributions</h2>
    <div class="keyfacts_cont table_spe distributes_div">
        <table class="distributesTable">
            <thead>
                <tr class="odd distributes_head">
                    <th style="width:16.5%">Ex-Date</th>
                    <th style="width:16.5%">Record Date</th>
                    <th style="width:16.5%">Pay Date</th>
                    <th style="width:15%">Amount</th>
                    <th style="width:16.5%">Frequency</th>
                    <th style="width:19%">Type</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="keyfacts_cont table_spe distributes_body" style="margin-top:0">
        <table>
            <tbody class="DividendsTable"></tbody>
        </table>
    </div>
</div>


<!-- Top 10 Holdings -->
<div class="keyfacts_sec" style="width:70%;margin-top:10px;">
    <h2>Top 10 Holdings</h2>
    <div class="keyfacts_cont table_spe">
        <table class="holdingsTable">
            <thead>
                <tr class="odd">
                    <th>Company</th>
                    <th>Ticker</th>
                    <th>Weight(%)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>    
        <a class="allHoldings" href="javascript:void(0)" style="margin-left: 570px;">See All Holdings</a>
    </div>
</div>

<!-- Short-Term Performance -->
<div class="keyfacts_sec table_spe" style="width:70%;margin-top:10px;">
    <h2>Short-Term Performance</h2>
    <div class="keyfacts_cont">
        <table class="ShortTermPerformanceTable">
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Price Return(%)</th>
                    <th>TotalReturn(%)</th>
                </tr>
            </thead>
            <tbody class="short_term_performance"></tbody>
        </table>    
    </div>
</div>

<!-- Long-Term Performance -->
<div class="keyfacts_sec table_spe" style="width:70%;margin-top:10px;">
    <h2>Long-Term Performance</h2>
    <div class="keyfacts_cont">
        <table class="longTermPerformanceTable">
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Price Return(%)</th>
                    <th>TotalReturn(%)</th>
                </tr>
            </thead>
            <tbody class="long_term_performance"></tbody>
        </table>    
    </div>
</div>


<!-- Performance By Year -->
<div class="keyfacts_sec table_spe" style="width:70%;margin:10px 0;">
    <h2>Performance By Year</h2>
    <div class="keyfacts_cont">
        <table class="performanceByYearTable">
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Price Return(%)</th>
                    <th>TotalReturn(%)</th>
                </tr>
            </thead>
            <tbody class="performance_by_year"></tbody>
        </table>    
    </div>
</div>
<style>
<!--
.old{background: #EEE none repeat scroll 0% 0% !important;}
-->
</style>

<div class="keyfacts_sec" style="border:none;"><h2>Related ETFs</h2></div>

<?php $this->renderPartial('/common/overviewajax');?>


