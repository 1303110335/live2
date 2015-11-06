<!-- filtering Sec -->
<div id="filtering_sec" class="etf_found_sec">
    <div class="etf_found_sec_cont">
        <h4>Found 123 of 1,700 ETF’s</h4>
        
        <div class="main_cont">
            <div class="filter_keyword_input">
                <input id="filterWord" name="Keyword Search" type="text" value="" placeholder="Filter by Keyword" />
                <div class="filter_search_bar_icon"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/search-icon-res.png" alt="Search" /></a></div>
            </div>

            <div id="US_Equities_res_list">
                <h3 id ="various9" href="#inline9">US Equities (Sector, Large-Cap)...</h3>
                <div class="double_arrow2"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/double-arrow-down.png" alt="Menu" /></div>
                <div class="clr"></div>
                
                <div style="display: none;">
                    <div id="inline9">
                        <div class="popup_cont">
                            <h3>List of all selections</h3>
                            <ul>
                                <li>US Stocks</li>
                                <li>Glbl/ Intl Stocks</li>
                                <li>US Bonds</li>
                                <li>Glbl/ Intl Bonds</li>
                                <li>Lorem</li>
                                <li>Ipsum</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu3" class="investment_res_list_cont">
                <div class="left_list_sec">
                    <div class="left_list_sec_block">
                    
                        <!-- start -->
                        <?php if(isset($arr))foreach($arr as $k => $row){?>
                        <div class="que_row">
                            <div class="accordion" id="section<?php echo $k+1;?>">
                                <input type="checkbox" name="check" value="<?php echo $row[0];?>" />
                                <label><?php echo $row[0];?></label>
                                <span></span>
                                <div class="clr"></div>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <!-- start -->
                                    <?php foreach($row as $k=>$son){?>
                                    <?php if($k==0)continue;?>
                                    <input type="checkbox" name="check" value="<?php echo $son;?>" />
                                    <label><?php echo $son;?></label>
                                    <div class="clr"></div>
                                    <?php }?>
                                    <!-- end -->
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <!-- end --> 
                           
                        <div class="select_clear_buttons">
                            <a href="javascript:void(0)"><img class="smallSearch" src="/images/select-all.png" alt="Select All" /></a>
                            <a style="margin-right:0px !important;" href="javascript:void(0)"><img src="/images/clear-button.png" alt="Clear" /></a>
                            <div class="clr"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="US_Equities_res_list">
                <ul class="cmpare_item_list">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                <div class="double_arrow3"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/compare.png" alt="Compare" /></a></div>
                <div class="clr"></div>
            </div>

            <ul id="flexiselDemo3">
                <li>
                    <div class="table_asset_sec_left_block">
                        <p>Age</p>
                        <div id="asset1" class="table_asset_sec_left_block_cont">
                            <div class="range_selector"><div id="Slider1" type="slider" name="area"></div></div>
                            <div class="apply"><a href="#">Apply</a><a href="#">Clear</a></div>
                        </div>   
                    </div>
                </li>
                <li>
                    <div class="table_asset_sec_left_block">
                        <p>Net Assets</p>
                        <div id="asset2" class="table_asset_sec_left_block_cont">
                            <div class="range_selector"><input id="Slider2" type="slider" name="area" value="2000;8000" /></div>
                            <script type="text/javascript" charset="utf-8">
                                jQuery("#Slider2").slider({ from: 0, to: 10000, scale: [0, '5000', 10000], limits: false, step: 1, 
                                    dimension: 'B', skin: "plastic", callback: function (value) { smallSlider(value,1,'Slider2'); } });
                            </script>

                            <div class="apply"><a href="#">Apply</a><a href="#">Clear</a></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="table_asset_sec_left_block">
                        <p>Expense Ratio</p>
                        <div id="asset3" class="table_asset_sec_left_block_cont">
                            <div class="range_selector"><input id="Slider3" type="slider" name="area" value="0;100" /></div>
                            <script type="text/javascript" charset="utf-8">
                                jQuery("#Slider3").slider({ from: 0, to: 100, scale: [0, 0.25, 0.50, 0.75, 1], limits: false, step: 1, 
                                    dimension: '', skin: "plastic", callback: function (value) {smallSlider(value,100,'Slider3'); } });
                            </script>

                            <div class="apply"><a href="#">Apply</a><a href="#">Clear</a></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="table_asset_sec_left_block">
                        <p>Trading Volume</p>
                        <div id="asset4" class="table_asset_sec_left_block_cont">
                            <div class="range_selector"><input id="Slider4" type="slider" name="area" value="1000;2000" /></div>
                            <script type="text/javascript" charset="utf-8">
                                jQuery("#Slider4").slider({ from: 0, to: 10000, scale: [0,  '5000',  10000], limits: false, step: 1, 
                                    dimension: 'B', skin: "plastic", callback: function (value) { smallSlider(value,1,'Slider4');} });
                            </script>

                            <div class="apply"><a href="#">Apply</a><a href="#">Clear</a></div>
                        </div>
                    </div>
                </li>
            </ul>
            
            <!-- start -->
            <div class="table_asset_sec">                       
                <div class="table_asset_sec_right">
                    <table>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td style="font-weight:600;">S&amp,P 500 Index Fund</td>
                            </tr>
                            <tr>
                                <td>Ticker</td>
                                <td>SPY</td>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <td>12.2 Years</td>
                            </tr>
                            <tr>
                                <td>Expense Ratio</td>
                                <td>0.15%</td>
                            </tr>
                            <tr>
                                <td>Assets</td>
                                <td>82.4B</td>
                            </tr>
                            <tr>
                                <td>1M Return</td>
                                <td>12.2%</td>
                            </tr>
                            <tr>
                                <td>3M Return</td>
                                <td>23.4%</td>
                            </tr>
                            <tr>
                               <td colspan="2" class="select"><a href="#">Select</a></td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="clr"></div>
            </div>
            <!-- end -->

        </div>
    </div>
</div>