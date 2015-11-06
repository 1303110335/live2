<?php $this->header('About Quotes & Analysis','Use the many ETFLive Screening Tools to search the universe of nearly 2000 US ETFs 
    to find the ones that best meet your needs','Quotes & Charting');?>
    
<!--  MARKET BETA CALCULATOR SEC -->

<?php $this->renderPartial('/common/marketBox',array('title'=>'Market Quote',
    'detail'=>'Quickly access the recent trading price for any
    ETF along with trading prices for its top 10 holdings (currently, only applicable when holdings are traded on a US stock exchange).'));?>

<?php $this->renderPartial('/common/marketBox',array('title'=>'advanced Charting',
    'detail'=>'Analysis historical performance of an ETF using
    our advanced charting capabilities. Perform technical analysis including moving averages,
    relative-strength indicators,candle stick and other commonly used charting features.'));?>

<?php $this->renderPartial('/common/marketBox',array('title'=>'Performance Comparison Tool',
    'detail'=>'Quickly compute and compare the total return
    performance (inclusive of dividend re-investment) of up to 5ETF during a desired period.'));?>
  
<?php $this->renderPartial('/common/marketBox',array('title'=>'Total Return Calculator',
    'detail'=>'Calculate the total return performance, inclusive of dividend re-investment,
    during a selected period.Override default closing values for starting and ending prices with desired prices.'));?>                  

<?php $this->renderPartial('/common/marketBox',array('title'=>'Historical Return Tool',
    'detail'=>'Quickly generate tables of weekly,monthly,quarterly or annual total returns. This data is avilable
    for download for further analysis by 3rd party applications, such as Microsoft Excel.'));?>                  

<?php $this->renderPartial('/common/marketBox',array('title'=>'Seasonality Analyzer',
    'detail'=>'Analysis historical ETF performance for seasonal biases in performance.'));?>     