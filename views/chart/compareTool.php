
<?php $this->header('Fund Screener','Comprehensively compare up to 5 ETFs simultaneously','ETFLive Compare Tool');?>

<div class="compare_section" style="border:1px solid #BBB;width: 68.6%;">
    <h4>Select upto 5 ETF’s to compare</h4>
    <ul class="compare_list">
        <?php for($i=0;$i<5;$i++){?>
                <li><h3 class="compareH3"><?php if(isset($ticker[$i]))echo $ticker[$i];else echo '';?></h3></li>
        <?php }?>
    </ul>
    <div class="compare_button"><a href="#">Compare</a></div>
    <div class="clr"></div>
</div>

<div class="investment_sec" style="display:block;margin-top:10px;">
    <div class="market_beta_cont_left">
        <div class="market_beta_cont_left_cont">
            <div class="tab_sec">
                <div class="tabs">
                    <div class="tab_link_res_top">
                        <div class="icons_bar_sec_mid" style="text-align:right !important;">
                            <a href="#"><img src="/images/share.png" alt="share"></a>
                            <a href="#"><img src="/images/email.png" alt="email"></a>
                            <a href="#"><img src="/images/attach.png" alt="attach"></a>
                        </div>
                    </div>
                    <div class="tab_link_cont">
                        <ul class="tab-links">
                            <li class="active"><a id="tabsummaryprofile" href="#tab1">Profile</a><a id="tabprofile" href="#tab1">Profile</a></li>
                            <li><a href="#tab2" class="gotoTab2">Performance</a></li>
                            <li><a href="#tab3" class="gotoTab3">Trading</a></li>
                            <li><a href="#tab4" class="gotoTab4">Risk</a></li>
                            <li><a href="#tab5" class="gotoTab5">Summary</a></li>
                        </ul>
                    </div>

                    <div class="tab-content" style="padding:10px;border:none;margin:0 0 20px;">
                        <div id="tab1" class="tab active">
                            <div class="subTab subTab1"></div>
                            <div class="subTab subTab2"></div>
                            <div class="subTab subTab3"></div>
                            <div class="subTab subTab4"></div>
                            <div class="subTab subTab5"></div>
                            <div class="subTab subTab6"></div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div id="tab2" class="tab"></div>

                        <div id="tab3" class="tab">
                            <div class="subTab subTab31"></div>
                            <div class="subTab subTab32"></div>
                            <div class="subTab subTab33"></div>
                            <div class="subTab subTab34"></div>
                            <div class="subTab subTab35"></div>
                            <div class="subTab subTab36"></div>
                            <div class="clearfix"></div>
                        </div>

                        <div id="tab4" class="tab">
                            <div class="subTab subTab41"></div>
                            <div class="subTab subTab42"></div>
                            <div class="subTab subTab43"></div>
                            <div class="subTab subTab44"></div>
                            <div class="subTab subTab45"></div>
                            <div class="subTab subTab46"></div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div id="tab5" class="tab">
                            
                        </div>
                    </div>
                    
                    <!-- TABLE -->
                    <div class="keyfacts_sec table_spe" style="width: 97%; border: medium none; padding: 0px 10px;">
                        <div class="keyfacts_cont">
                            <table class="ajaxChartTable">
                                <?php echo $table;?>
                            </table>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="icons_bar_sec">
                <div class="icons_bar_sec_left">
                    <a href="#"><img src="/images/prev.png" alt="prev"></a>
                    <a href="#"><img src="/images/prev-item.png" alt="prev-item"></a>
                </div>
                <div class="icons_bar_sec_right">
                    <a href="#"><img src="/images/next-item.png" alt="next-item"></a>
                    <a href="#"><img src="/images/next.png" alt="next"></a>
                </div>
                <div class="icons_bar_sec_mid">
                    <a href="#"><img src="/images/pdf.png" alt="pdf"></a>
                    <a href="#"><img src="/images/email.png" alt="email"></a>
                    <a href="#"><img src="/images/share.png" alt="share"></a>
                    <a href="#"><img src="/images/attach.png" alt="attach"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="market_beta_cont_right"><img src="/images/advertisement.png" alt="advertisement"></div>
    <div class="clr"></div>
    <div class="jsonResult" style="display:none;"><?php echo $result;?></div>
    <div class="jsonTab2" style="display:none;"><?php echo $tab2;?></div>
    <div class="jsonTab3" style="display:none;"><?php echo $tab3;?></div>
    <div class="jsonTab4" style="display:none;"><?php echo $tab4;?></div>
</div>

<script src="/js/highcharts.js"></script>
<script src="/js/exporting.js"></script>
<script type="text/javascript" src="/js/etf/compareTool.js"></script>



