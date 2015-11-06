<?php $this->header('Holdings Screener','Find all ETFs with specified threshold positions in selected holding','',false);?>

<div class="etf_found_sec_cont"><h2>Found <span class="fundNumber">0</span> of <span><?php echo $this->totalETFs();?></span> ETFs</h2></div>

<div class="holding_box">
    <div class="holding_top">
        <h2>Show All ETF Holdings</h2>
        <?php $this->renderPartial('/common/search');?> 
    </div>
    
    <div class="holding_bottom">
        <h2>Exclude if weighting less than</h2>
        <select id="weightSelect" name="select" value="">
            <option value="0">None</option>
            <option value="0.005">0.5%</option>
            <option value="0.01">1.0%</option>
            <option value="0.05">5.0%</option>
            <option value="0.1">10.0%</option>
        </select>
        <h2 class="specials">Exclude</h2>
        <select id="inverSelect" name="select" value="">
            <option value="">None</option>
            <option value="InverseIndicator">Inverse ETFs</option>
            <option value="fundLeverage">Leverage ETFs</option>
            <option value="all">Inverse & Leverage ETFs</option>
        </select>
        <br/>
    </div>
</div>

<script type="text/javascript">

$(function(){

	$('.search_out').css({width:"40%",float:"left"});
	$('.search_tip').css({top:"51px",width:"375px"});
	$('.search_new').css('margin-top','10px');
	//dropdown list change
	$('#weightSelect').change(function(){
	    var weight = $(this).val();
	    var inver = $('#inverSelect option:selected').val();
	    addAjax(weight,inver);
	});

	$('#inverSelect').change(function(){
	    var inver = $(this).val();
	    var weight = $('#weightSelect option:selected').val();
	    addAjax(weight,inver);
	});
    
	//showTickers
	showTickers('/inside/holdings');

	function addAjax(weight,inver){
	    var keyword = $('.search_newname').val();
	    keyword = $.trim(keyword.replace(/-.*/ig,''));
	    $.ajax({
		   type: "GET",
		   url: "/inside/holdings",
		   datatype:'html',
		   data:{'keyword':keyword,'weight':weight,'inver':inver},
		   success: function(data){
			   if(data){
				   $('.loadingPics').empty();
				   addArray(data);
			   }else {
				   $('.investment_sec').css('display','block');
				   $('.loadingPic').css('display','none');
				   $('.loadingPics').empty().append('<div style="margin:10px;">没有相关的数据!</div>');
			   }
		   }
		});
	}

	//order by title desc or asc
    $('.sortClass th').click(function(){
        if($(this).html()=='Select')return false;
        //judge the table is empty or not
        if($('.ajaxTable').html()=='') return false;
        //desc or asc
        var order = fixOrder($(this));
        //get the title
        var title = $(this).html();
        //get the input text
        var keyword = $('.search_newname').val();
        keyword = $.trim(keyword.replace(/-.*/ig,''));
        //get the weight and inver
        var inver = $('#inverSelect option:selected').val();
	    var weight = $('#weightSelect option:selected').val();
        $.ajax({
    	   type: "GET",
    	   url: "/inside/holdings",
    	   datatype:'json',
    	   data:{'weight':weight,'inver':inver,'key':title,'keyword':keyword,'order':order},
    	   success: function(data){
    		   addArray(data);
    	   }
    	});
    });
}) 
</script>

<?php $this->renderPartial('/common/overviewajax');?>
