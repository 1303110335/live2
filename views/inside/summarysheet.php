
<?php $this->header('Fund Viewer','In-depth summary of selected ETF','ETF Summary Sheet');?>

<!-- iShare Sec -->
<?php $this->renderPartial('/common/iShare',array('res'=>$res));?>



<?php if(!empty($res)) $this->renderPartial('/common/investment',array('res'=>$res));
      else $this->renderPartial('/common/investment');
?>

<!-- dividends -->
<div class="keyfacts_sec" style="width:70%;margin:10px 0;">
    <h2>Distributions</h2>
    <div class="keyfacts_cont table_spe">
        <table>
            <thead>
                <tr class="odd">
                    <th>Record Date</th>
                    <th>Pay Date</th>
                    <th>Ex-Date</th>
                    <th>Amount</th>
                    <th>Frequency</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody class="DividendsTable">
            <?php $flag = false;?>
            <?php if(!empty($dividends)) foreach($dividends as $row){?>
            <?php if($flag==true) {echo '<tr class="odd">';}else {echo '<tr>';}?>
                    <td><?php echo $row->RecordDate;?></td>
                    <td><?php echo $row->PayDate;?></td>
                    <td><?php echo $row->ExDate;?></td>
                    <td><?php echo $row->DividendAmount;?></td>
                    <td><?php echo $row->PaymentFrequency;?></td>
                    <td><?php echo $row->Type;?></td>
                </tr>
            <?php $flag=!$flag;}?>
            </tbody>
        </table>    
    </div>
</div>


<!-- Top 10 Holdings -->
<div class="keyfacts_sec" style="width:70%;margin-top:10px;">
    <h2>Top 10 Holdings</h2>
    <div class="keyfacts_cont table_spe">
        <table>
            <thead>
                <tr class="odd">
                    <th>Company</th>
                    <th>Ticker</th>
                    <th>Weight(%)</th>
                </tr>
            </thead>
            <tbody class="holdingsTable">
            <?php $flag = false;?>
            <?php if(isset($holdings)) foreach($holdings as $row){?>
            <?php if(empty($row['company']))continue;?>
            <?php if($flag==true) {echo '<tr class="odd">';}else {echo '<tr>';}?>
                    <td><?php echo $row['company'];?></td>
                    <td><?php echo $row['ticker'];?></td>
                    <td><?php echo $row['weight']?></td>
                </tr>
            <?php $flag=!$flag;}?>
            </tbody>
        </table>    
        <a class="allHoldings" href="javascript:void(0)" style="margin-left: 570px;">See All Holdings</a>
    </div>
</div>

<script style="text/javascript">
$(function(){

	$('.loadingPic').css('display','none');
	$('.investment_sec').css('display','block');
	//all holdings
	$('.allHoldings').click(function(){
	    var name = $('.ivv_heading_block h3').html();
		$.ajax({
	  	   type: "POST",
	  	   url: "/inside/fundviewer",
	  	   datatype:'html',
	  	   data:{'name':name},
	  	   success: function(data){
			  $('.holdingsTable').empty().append(data);
	  	   }
	  	});
	    
	});

    //order by title desc or asc
    $('.sortClass th').click(function(){
        if($(this).html()=='Select')return false;
        //judge the table is empty or not
        if($('.ajaxTable').html()=='') return false;
        //desc or asc
        var order = fixOrder($(this));
        //get the title
        var title = $(this).html();
        //get the keyword
        var keyword = $.trim($('.ivv_heading_block h3').html());
        $.ajax({
    	   type: "POST",
    	   url: "/inside/fundviewer",
    	   datatype:'json',
    	   data:{'keyword':keyword,'key':title,'order':order},
    	   success: function(data){
    		   addArray(data);
    	   }
    	});
    });
});
</script>
<!-- Performance -->
<div class="keyfacts_sec table_spe" style="width:70%;margin-top:10px;">
    <h2>Performance</h2>
    <div class="keyfacts_cont">
        <table>
            <thead>
                <tr class="odd">
                    <th style="width:31%;">Short-Term Performance</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th>Period</th>
                    <th>Price Return(%)</th>
                    <th>TotalReturn(%)</th>
                    <th>After-Tax Return</th>
                </tr>
            </thead>
            <tbody>
                <tr class="old">
                    <td>1 Month</td>
                    <td><?php if(!empty($performance->p1MPR))echo $performance->p1MPR;?></td>
                    <td><?php if(!empty($performance->p1MTR))echo $performance->p1MTR;?></td>
                    <td><?php if(!empty($performance->p1MATR))echo $performance->p1MATR;?></td>
                </tr>
                <tr>
                    <td>3 Month</td>
                    <td><?php if(!empty($performance->p3MPR))echo $performance->p3MPR;?></td>
                    <td><?php if(!empty($performance->p3MTR))echo $performance->p3MTR;?></td>
                    <td><?php if(!empty($performance->p3MATR))echo $performance->p3MATR;?></td>
                </tr>
                <tr class="old">
                    <td>6 Month</td>
                    <td><?php if(!empty($performance->p6MPR))echo $performance->p6MPR;?></td>
                    <td><?php if(!empty($performance->p6MTR))echo $performance->p6MTR;?></td>
                    <td><?php if(!empty($performance->p6MATR))echo $performance->p6MATR;?></td>
                </tr>
                <tr>
                    <td>YeartoDate</td>
                    <td><?php if(!empty($performance->pYTDPR))echo $performance->pYTDPR;?></td>
                    <td><?php if(!empty($performance->pYTDTR))echo $performance->pYTDTR;?></td>
                    <td><?php if(!empty($performance->pYTDATR))echo $performance->pYTDATR;?></td>
                </tr>
                <tr class="old">
                    <td>1 Year</td>
                    <td><?php if(!empty($performance->p1YPR))echo $performance->p1YPR;?></td>
                    <td><?php if(!empty($performance->p1YTR))echo $performance->p1YTR;?></td>
                    <td><?php if(!empty($performance->p1YATR))echo $performance->p1YATR;?></td>
                </tr>
                <tr>
                    <td>3 Year</td>
                    <td><?php if(!empty($performance->P3YPR))echo $performance->P3YPR;?></td>
                    <td><?php if(!empty($performance->P3YTR))echo $performance->P3YTR;?></td>
                    <td><?php if(!empty($performance->P3YATR))echo $performance->P3YATR;?></td>
                </tr>
                <tr class="old">
                    <td>5 Year</td>
                    <td><?php if(!empty($performance->P5YPR))echo $performance->P5YPR;?></td>
                    <td><?php if(!empty($performance->P5YTR))echo $performance->P5YTR;?></td>
                    <td><?php if(!empty($performance->P5YATR))echo $performance->P5YATR;?></td>
                </tr>
                <tr>
                    <td>10 Year</td>
                    <td><?php if(!empty($performance->P10YPR))echo $performance->P10YPR;?></td>
                    <td><?php if(!empty($performance->P10YTR))echo $performance->P10YTR;?></td>
                    <td><?php if(!empty($performance->P10YATR))echo $performance->P10YATR;?></td>
                </tr>
            </tbody>
        </table>    
    </div>
</div>
<!-- Performance By Year -->
<div class="keyfacts_sec table_spe" style="width:70%;margin:10px 0;">
    <h2>Performance By Year</h2>
    <div class="keyfacts_cont">
        <table>
            <thead>
                <tr class="odd">
                    <th style="width:31%;">Short-Term Performance</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th>Period</th>
                    <th>Price Return(%)</th>
                    <th>TotalReturn(%)</th>
                    <th>After-Tax Return</th>
                </tr>
            </thead>
            <tbody>
                <tr class="old">
                    <td>2014</td>
                    <td><?php if(!empty($performance->p2014TR))echo $performance->p2014TR;?></td>
                    <td><?php if(!empty($performance->p2014PR))echo $performance->p2014PR;?></td>
                    <td><?php if(!empty($performance->p2014ATR))echo $performance->p2014ATR;?></td>
                </tr>
                <tr>
                    <td>2013</td>
                    <td><?php if(!empty($performance->p2013TR))echo $performance->p2013TR;?></td>
                    <td><?php if(!empty($performance->p2013PR))echo $performance->p2013PR;?></td>
                    <td><?php if(!empty($performance->p2013ATR))echo $performance->p2013ATR;?></td>
                </tr>
                <tr class="old">
                    <td>2012</td>
                    <td><?php if(!empty($performance->p2012TR))echo $performance->p2012TR;?></td>
                    <td><?php if(!empty($performance->p2012PR))echo $performance->p2012PR;?></td>
                    <td><?php if(!empty($performance->p2012ATR))echo $performance->p2012ATR;?></td>
                </tr>
                <tr>
                    <td>2011</td>
                    <td><?php if(!empty($performance->p2011TR))echo $performance->p2011TR;?></td>
                    <td><?php if(!empty($performance->p2011PR))echo $performance->p2011PR;?></td>
                    <td><?php if(!empty($performance->p2011ATR))echo $performance->p2011ATR;?></td>
                </tr>
            </tbody>
        </table>    
    </div>
</div>
<style>
<!--
.old{background: #EEE none repeat scroll 0% 0% !important;}
-->
</style>

<div class="keyfacts_sec" style="border:none;"><h2>Related ETFs</h2></div>

<?php if(isset($relations)) $this->renderPartial('/common/overviewajax',array('res'=>$relations));
      else $this->renderPartial('/common/overviewajax');
?>


