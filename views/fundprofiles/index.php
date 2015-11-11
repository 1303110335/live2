
<div class="research">

    <form name="research">
        <?php $this->renderPartial('/common/search');?>
        <div style="clear:both;"></div>
    </form>
</div>

<script type="text/javascript">

//show the etf ticker and name
$(function(){

    //hide the top
    $('.top').css('display','none');
	
	//showTickers and fullName
	showTickers('/inside/related');
    
	/*隐藏搜索框*/
	if($(window).width()>770)$('.search_bar').css('display','none');
 	if($(window).width()<=770){
		/*$('.search_out').css('margin-left','0px !important');
		$('.search_spe').css('margin-left','0px !important');*/
		$('.research').remove();
	} 
	$('.search_tip').css('top','160px');
	$('.search_out').css('margin-left','300px');
	$('.search_new').css('margin-top','120px');
	$('.search_new').append('<div class="search_bar_icon">'+
			'<input style="background: url(/images/search-icon.png) no-repeat" class="searchBtn" type="button"></div>'
	);
	$('.search_bar_icon input[type=button]').css({border:'medium none'});

	$('.search_new').after(
			'<div class="moreClass">More about&nbsp;&nbsp;'+
			'<a href="#">Screening Tools</a>, &nbsp;'+
			'<a href="#">Quotes & Charting</a>, &nbsp;'+
			'<a href="#">Tools & Analytics</a>, &nbsp;'+
			'<a href="#">&Portfolios</a></div>');
    });
    $(".research").delegate(".searchBtn","click",function(){
    	redirectToSummary();
	});

    $(window).keydown(function(event){
        if(event.keyCode== 13){
        	redirectToSummary();
        }
  	});
  	
  	function redirectToSummary(){
  		var ticker = $.trim($('.search_newname').val());
	    window.location.href='/inside/fundViewer/ticker/'+ticker;
    }
</script>

