<!--Overview Tabs Sec-->
<div class="investment_sec">
    <div id="overview_res" class="market_beta_cont_left">
        <div class="market_beta_cont_left_cont">
            <div class="tab_sec" style="background:none;">
                <div class="tabs" style="padding-bottom:0;">
                    <div class="tab_link_cont" style="background:#fff;">
                        <ul class="tab-links">
                            <li class="active"><a href="#tab5">Overview</a></li>
                            <li><a href="#tab6">S/T Performance</a></li>
                            <li><a href="#tab7">L/T Performance</a></li>
                            <li><a href="#tab8">Trading</a></li>
                            <li><a href="#tab9">Risk</a></li>
                        </ul>
                    </div>

                    <div>
                        <div id="tab5" >
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                		<th>ticker</th>
                                		<th>fullName</th>
                                		<th style="width:80px;">expenseRatio</th>
                                		<th>investmentAdvisor</th>
                                		<th>firstTradeDate</th> 
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable">
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
                            
                        </div>

                        <div id="tab6" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                		<th>Performance (1M)</th>
                                		<th>Performance (3M)</th>
                                		<th>Performance (YTD)</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable2"></tbody>
                            </table>
                        </div>

                        <div id="tab7" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                		<th>Performance (1Y)</th>
                                		<th>Performance (3Y)</th>
                                		<th>Performance (5Y)</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable3"></tbody>
                            </table>
                        </div>

                        <div id="tab8" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                		<th>Average Volume 30D</th>
                                		<th>Average $ Volume 30D</th>
                                		<th>Number of Holdings</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable4"></tbody>
                            </table>
                        </div>

                        <div id="tab9" class="tab" style="display:none;">
                            <table class="responsive" id="overview-table">
                                <thead>
                                	<tr class="head">
                                	    <th>ticker</th>
                                		<th>Volatility (30D)</th>
                                		<th>Beta (S&P 500)</th>
                                		<th>Correlation (S&P 500)</th>
                                		<th style="background-image:none !important;">Select</th>
                                	</tr>
                                </thead>
                                <tbody class="ajaxTable5"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="compare_section">
                <h4>Select upto 5 ETF’s to compare</h4>
                <ul class="compare_list">
                    <li style="border:1px solid #cbcdcc;"></li>
                    <li style="border:1px solid #cbcdcc;"></li>
                    <li style="border:1px solid #cbcdcc;"></li>
                    <li style="border:1px solid #cbcdcc;"></li>
                    <li style="border:1px solid #cbcdcc;"></li>
                </ul>
                <div class="compare_button"><a href="#">Compare</a></div>
                <div class="clr"></div>
            </div>
        </div>
    </div>

    <div class="market_beta_cont_right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/advertisement.png" alt="advertisement" /></div>
    <div class="clr"></div>
</div>
<script type = "text/javascript">
    function checkCont(){
    	$('.cont').click(function(){
            var ticker = $(this).val();
            $flag = true;
            $('.compare_list li').each(function(){
            	//remove the title
            	var content = $(this).html();
            	var replace = /<h3 .*>(.*)<\/h3>/ig;
            	var result = content.replace(replace,'$1');
            	
                if(ticker == result){
                    $(this).remove();
                    $('.compare_list').append('<li style="border:1px solid #cbcdcc;"></li>');
                    return false;
                }
                //add the title
                if($(this).html()==''){
                	$(this).append('<h3 style="color:#fff; background:#00a8e8;">'+ticker+'</h3>');
                	return false;
                }
            });
        });
    }

    $(function(){
        //check the checkbox and add record into the compare_list
        checkCont();

        //order by title desc or asc
        $('.head th').click(function(){
            if($(this).html()=='Select')return false;
            var order = fixOrder($(this));
            var key = $(this).html();
            var location = window.location.search;
            var replace = /\?sql=/ig;
            var result = location.replace(replace,'');
            $.ajax({
  	    	   type: "GET",
  	    	   url: "/inside/index",
  	    	   datatype:'html',
  	    	   data:{'sql':result,'key':key,'order':order},
  	    	   success: function(data){
  		    	    if(data){
  	  		    	    $('.ajaxTable').empty();
  	  		    	    $('.ajaxTable').append(data);
  	  	  		    	checkCont();
  		    	   } 
  	    	   }
  	    	});
        });
    });
</script>