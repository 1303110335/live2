<!-- Investment Sec -->
<div class="market_beta_cont_left" style="width:37%;margin-top:10px;">
    <div class="market_beta_cont_left_cont">
        <div class="investment_sec_right" style="float: left;width:100%;">
                <div class="investment_sec_right_top">
                    <h2 style="font-size:22px;">Investment Objectives</h2>
                    <?php if(!empty($res->investmentObjective)) echo $res->investmentObjective;
                          else echo "<p>have no data yet!</p>";?>
                </div>
                <div class="keyfacts_sec">
                    <h2 style="font-size:22px;">Key Facts</h2>
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
<div class="clr"></div>