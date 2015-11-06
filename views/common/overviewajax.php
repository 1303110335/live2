<!--Overview Tabs Sec-->
<div class="investment_sec">
    <div id="overview_res" class="market_beta_cont_left">
    
        <div class="compare_section">
            <h4>Select upto 5 ETF’s to compare</h4>
            <ul class="compare_list">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="compare_button"><a href="javascript:;">Compare</a></div>
            <div class="clr"></div>
        </div>

        <div class="market_beta_cont_left_cont">
            <div class="tab_sec" style="background:none;">
                <div class="tabs" style="padding-bottom:0;">
                    <div class="tab_link_cont" style="background:#fff;">
                        <ul class="tab-links">
                            <li class="active"><a href="#tab5">Profile</a></li>
                            <li><a href="#tab6">S/T Performance</a></li>
                            <li><a href="#tab7">L/T Performance</a></li>
                            <li><a href="#tab8">Trading</a></li>
                            <li><a href="#tab9">Risk</a></li>
                        </ul>
                    </div>

                    <div class="sortClass">
                        <div id="tab5" >
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                		<th>ticker</th>
                                		<th style="width:100%;">fullName</th>
                                		<th style="width:80px;">expenseRatio</th>
                                		<th>investmentAdvisor</th>
                                		<th>firstTradeDate</th> 
                                		<th style="background-image:none !important;padding:0 !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable1">
                                    <?php if(isset($res)){ foreach($res as $row){?>
                                	<tr>
                                		<td class="t-left"><?php echo $row->ticker;?></td>
                                		<td class="t-left"><?php echo $row->fullName;?></td>
                                		<td><?php echo $row->expenseRatio;?></td>
                                		<td><?php echo $row->investmentAdvisor;?></td>
                                		<td><?php echo $row->firstTradeDate;?></td>
                                		<td><input class="cont" type="checkbox" name="select" value="<?php echo $row->ticker;?>" /></td>
                                	</tr>
                                 <?php }}?>
                                </tbody>
                                
                            </table> 
                            <div class="loadingPics">
	                                 <img src="/images/loading3.gif" class="loadingPic" alt="loading"/>
                            </div>     
                        </div>

                        <div id="tab6" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                	    <th style="width:100%;">fullName</th>
                                		<th>Performance (1M)</th>
                                		<th>Performance (3M)</th>
                                		<th>Performance (YTD)</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable2">
                                    <?php if(isset($res)){ foreach($res as $row){?>
                                	<tr>
                                		<td class="t-left"><?php echo $row->ticker;?></td>
                                		<td class="t-left"><?php echo $row->fullName;?></td>
                                		<td class="t-left"><?php echo $row->p1MPR;?></td>
                                		<td><?php echo $row->p3MPR;?></td>
                                		<td><?php echo $row->pYTDPR;?></td>
                                		<td><input class="cont" type="checkbox" name="select" value="<?php echo $row->ticker;?>" /></td>
                                	</tr>
                                 <?php }}?>
                                </tbody>
                            </table>
                        </div>

                        <div id="tab7" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                	    <th style="width:100%;">fullName</th>
                                		<th>Performance (1Y)</th>
                                		<th>Performance (3Y)</th>
                                		<th>Performance (5Y)</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable3">
                                    <?php if(isset($res)){ foreach($res as $row){?>
                                	<tr>
                                		<td class="t-left"><?php echo $row->ticker;?></td>
                                		<td class="t-left"><?php echo $row->fullName;?></td>
                                		<td class="t-left"><?php echo $row->p1YPR;?></td>
                                		<td><?php echo $row->P3YPR;?></td>
                                		<td><?php echo $row->P5YPR;?></td>
                                		<td><input class="cont" type="checkbox" name="select" value="<?php echo $row->ticker;?>" /></td>
                                	</tr>
                                 <?php }}?>
                                </tbody>
                            </table>
                        </div>

                        <div id="tab8" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                	    <th style="width:100%;">fullName</th>
                                		<th>Average Volume 30D</th>
                                		<th>Average $ Volume 30D</th>
                                		<th>Number of Holdings</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable4">
                                    <?php if(isset($res)){ foreach($res as $row){?>
                                	<tr>
                                		<td class="t-left"><?php echo $row->ticker;?></td>
                                		<td class="t-left"><?php echo $row->fullName;?></td>
                                		<td class="t-left"><?php echo $row->adtv30d;?></td>
                                		<td><?php echo $row->adtv30dDollars;?></td>
                                		<td><?php echo $row->numHoldings;?></td>
                                		<td><input class="cont" type="checkbox" name="select" value="<?php echo $row->ticker;?>" /></td>
                                	</tr>
                                 <?php }}?>
                                </tbody>
                            </table>
                        </div>

                        <div id="tab9" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                	    <th style="width:100%;">fullName</th>
                                		<th>Volatility (30D)</th>
                                		<th>Beta (S&P 500)</th>
                                		<th>Correlation (S&P 500)</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable5">
                                    <?php if(isset($res)){ foreach($res as $row){?>
                                	<tr>
                                		<td class="t-left"><?php echo $row->ticker;?></td>
                                		<td class="t-left"><?php echo $row->fullName;?></td>
                                		<td class="t-left"><?php echo $row->vol30d;?></td>
                                		<td><?php echo $row->betaSPY;?></td>
                                		<td><?php echo $row->correlSPY;?></td>
                                		<td><input class="cont" type="checkbox" name="select" value="<?php echo $row->ticker;?>" /></td>
                                	</tr>
                                 <?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="pager"></div>
        </div>
    </div>

    <div class="market_beta_cont_right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/advertisement.png" alt="advertisement" /></div>
    <div class="clr"></div>
</div>

<script type = "text/javascript" src="/js/etf/overajax.js"></script>