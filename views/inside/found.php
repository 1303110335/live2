<?php $this->header('Fund Screener','Screen our ETF universe using asset class investment strategy and further refine results by various criteria and keywords','',false);?>
<link rel="stylesheet" href="/js/slider/jquery-ui.css" style="text/css">
<link rel="stylesheet" href="/js/slider/style.css" style="text/css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/slider/jquery-ui.js"></script>
<!-- ETF Found Sec -->
<div class="etf_found_sec">
    <div class="etf_found_sec_cont">
        <h2>Found <span class="fundNumber">0</span> of <?php $this->totalETFs();?> ETFs</h2>
        <div class="main_cont">
            <?php $this->renderPartial('/common/checklist',array('checkModel'=>$arr));?>

            <!-- check_list bottom -->
            <div class="below_checkbox_sec">
                <h3>Refine Criteria</h3>
                <div class="below_checkbox_sec_left">
                    <div class="below_checkbox_sec_left_top">
                        <!-- class="active" -->
                        <div class="silder siltop">
                            <span class="active" style="font-weight:bold;">Most Common</span>
                        </div>
                        <div class="silder cons">
                            <div><span>Net Assets</span></div>
                            <div><span>Age</span></div>
                            <div><span>Expense Ratio</span></div>
                            <div><span>Average Volume (30D)</span></div>
                            <div><span>Div Yield</span></div>
                        </div>
                        
                        <div class="silder siltop">
                            <span style="font-weight:bold;">Performance</span>
                        </div>
                        <div class="silder cons sub">
                            <div><span>Price Return (1M)</span></div>
                            <div><span>Price Return (3M)</span></div>
                            <div><span>Price Return (6M)</span></div>
                            <div><span>Total Return (YTD)</span></div>
                            <div><span>Price Return (1Y)</span></div>
                        </div>
                        
                        <div class="silder siltop">
                            <span style="font-weight:bold;">Statistics</span>
                        </div>
                        <div class="silder cons sub" style="border-bottom:1px solid rgb(203,205,204)">
                            <div><span>Volatility (30D)</span></div>
                            <div><span>Volatility (1Y)</span></div>
                            <div><span>Beta (SPY)</span></div>
                            <div><span>Correlation (SPY)</span></div>
                        </div>
                    </div>     
                </div>
                <div class="below_checkbox_sec_right">
                    <ul>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <div class="clr"></div>
                    <div class="filter_checkbox_sec">
                        <div class="keyword_filter"><input id="key" name="Keyword Search" type="text" value="" placeholder="Filter by Keyword" /></div>
                        <div class="checkbox_list_col2">
                            <div class="checkbox_list_col_block">
                                <input class="inverse" type="checkbox" name="check" value="inverse" checked/>
                                <label class="cludeClass">Excluded Inverse</label>
                                <div class="clr"></div>
                            </div>
                            <div class="checkbox_list_col_block">
                                <input class="leverage" type="checkbox" name="check" value="leverage" checked />
                                <label class="cludeClass">Exclude Leverage</label>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    
                </div>
                <div class="clr"></div>

            </div>

            <div class="clear_search_bar">
                <a href="javascript:void(0)"><img class="searchAll" src="<?php echo Yii::app()->request->baseUrl; ?>/images/search-button.png" alt="Search" /></a>
                <a href="javascript:void(0)"><img class="clearAll" src="<?php echo Yii::app()->request->baseUrl; ?>/images/clear-button.png" alt="Clear" /></a>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>


<!-- show the ETF table and compare -->
<?php $this->renderPartial('/common/overviewajax',array('arr'=>$arr));?>
<script type="text/javascript" src="/js/etf/found.js"></script>