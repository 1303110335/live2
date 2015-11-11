<!-- Investment Sec -->
<div class="investment_sec">
            <div class="market_beta_cont_left">
                <div class="market_beta_cont_left_cont">
                    <div id="investment_left_list" class="left_list_sec">
                        <div class="left_list_sec_block">
                            <h3>Profile</h3>
                            <ul>
                                <li class="summaryUrl"><a href="#">Summary Sheet</a></li>
                                <li><a href="#">Issuer Fact Sheet</a></li>
                                <li><a href="#">Related ETF's</a></li>
                            </ul>
                        </div>
                        <div class="left_list_sec_block">
                            <h3>Quote & Analysis</h3>
                            <ul>
                                <li><a href="#">Market Quote</a></li>
                                <li><a href="#">Advanced Charls</a></li>
                                <li><a href="#">Historic Returns</a></li>
                                <li><a href="#">Seasonality Chart</a></li>
                            </ul>
                        </div>
                        <div class="left_list_sec_block">
                            <h3>Statistical Tools</h3>
                            <ul>
                                <li><a href="#">Daily Returns</a></li>
                                <li><a href="#">Market Beta</a></li>
                                <li><a href="#">Volatility Chart</a></li>
                                <li><a href="#">Correlation Chart</a></li>
                                <li><a href="#">Spread Trade Analysis</a></li>
                            </ul>
                        </div>
                        <div class="left_list_sec_block">
                            <h3>Portfolio</h3>
                            <ul>
                                <li><a href="#">Add to Portfolio</a></li>
                            </ul>
                        </div>
                        
                    </div>

                    <div class="investment_sec_right">
                            <div id="investment_res_list">
                                <h3>iShares S&P 500 Index ETF</h3>
                                <div class="double_arrow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/double-arrow-down.png" alt="Menu" /></div>
                                <div class="clr"></div>
                                <div id="menu2" class="investment_res_list_cont">
                                    <div class="left_list_sec">
                                        <div class="left_list_sec_block">
                                            <h3>Profile</h3>
                                            <ul>
                                                <li><a href="#">Summary Sheet</a></li>
                                                <li><a href="#">Issuer Fact Sheet</a></li>
                                                <li><a href="#">Related ETF's</a></li>
                                            </ul>
                                        </div>
                                        <div class="left_list_sec_block">
                                            <h3>Quote & Analysis</h3>
                                            <ul>
                                                <li><a href="#">Market Quote</a></li>
                                                <li><a href="#">Advanced Charls</a></li>
                                                <li><a href="#">Historic Returns</a></li>
                                                <li><a href="#">Seasonality Chart</a></li>
                                            </ul>
                                        </div>
                                        <div class="left_list_sec_block">
                                            <h3>Statistical Tools</h3>
                                            <ul>
                                                <li><a href="#">Daily Returns</a></li>
                                                <li><a href="#">Market Beta</a></li>
                                                <li><a href="#">Volatility Chart</a></li>
                                                <li><a href="#">Correlation Chart</a></li>
                                                <li><a href="#">Spread Trade Analysis</a></li>
                                            </ul>
                                        </div>
                                        <div class="left_list_sec_block">
                                            <h3>Portfolio</h3>
                                            <ul>
                                                <li><a href="#">Add to Portfolio</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="investment_sec_right_top">
                                <h2>Investment Objectives</h2>
                                <?php if(!empty($res->investmentObjective)) echo $res->investmentObjective;
                                      else echo "<p>Lorem ipsum dolor sit amet, consectetur adicing the elit. Morbi ultricies
                                            eget ante vel consectetur. Namoies cursus justo ipsum, vitae convallis ex viverra sed. Vivamus varius 
                                            erat id elit blandit, ttis leo vestibulum.</p>";
                                ?>
                                
                            </div>
                            <div class="keyfacts_sec">
                                <h2>Key Facts</h2>
                                <div class="keyfacts_cont">
                                    <table>
                                        <tbody>
                                            <tr class="odd">
                                                <td class="border_right">Espense Ratio</td>
                                                <td class="expenseRatio"><?php if(isset($res)) echo $res->expenseRatio;else echo "0.12%";?></td>
                                            </tr>
                                            <tr>
                                                <td class="border_right">firstTradeDate</td>
                                                <td class="firstTradeDate"><?php if(isset($res)) echo $res->firstTradeDate;else echo "Jan 1 2001";?></td>
                                            </tr>
                                            <tr class="odd">
                                                <td class="border_right">indexName</td>
                                                <td class="indexName"><?php if(isset($res)) echo $res->indexName;else echo "S&P 500 Index";?></td>
                                            </tr>
                                            <tr>
                                                <td class="border_right">numHoldings</td>
                                                <td class="impliedLiquidity"><?php if(isset($res)) echo $res->numHoldings;else echo "506";?></td>
                                            </tr>
                                            <tr class="odd">
                                                <td class="border_right">distributionFrequency</td>
                                                <td class="distributionFrequency"><?php if(isset($res)) echo $res->distributionFrequency;else echo "Quaterly";?></td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                            </div>

                        </div>
                    <div class="clr"></div>
                </div>
 
            </div>
           
            <div class="market_beta_cont_right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/advertisement.png" alt="advertisement" /></div>
            <div class="clr"></div>
        </div>