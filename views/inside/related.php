<?php $this->header('Related ETF Finder','Select ETF and find those ETFs that are most corrlated,either positively or negatively','',false);?>
<link rel="stylesheet" href="/js/slider/jquery-ui.css" style="text/css">
<link rel="stylesheet" href="/js/slider/style.css" style="text/css">
<script type="text/javascript" src="/js/slider/jquery-ui.js"></script>
<div class="etf_found_sec_cont"><h2>Found <span class="fundNumber">0</span> of <span><?php echo $this->totalETFs();?></span> ETFs</h2></div>

<div class="box_new">
    <?php $this->renderPartial('/common/search');?> 
    
    <div id="corrs" class="criteria-panel-container">
        <div class="criteria-panel"  style="margin:9px 50px;">
          <div class="panel-title">
            correlation
          </div>
          <a class="panel-close">x</a>
          <p>
            <div class="slider-range sliderSize" id="corr"></div>
            <div class="slider-range-details">
              <span class="min-item range-item">-1</span>
              <span class="max-item range-item pull-right">1</span>
            </div>
          </p>
        </div>
      </div>
    
    <div class="slider_new">
        <div class="check_new">
            <input class="inverse" name="check" checked value="inverse" type="checkbox" style="margin-left:10px;">
            <label>Excluded Inverse</label>
        </div>
        <div class="check_new">
            <input class="leverage" name="check" checked value="leverage" type="checkbox" style="margin-left:10px;">
            <label>Exclude Leverage</label>
        </div>
    </div>
</div>

<?php $this->renderPartial('/common/overviewajax');?>

<script type="text/javascript">
$(function(){
	//showTickers and fullName
	showTickers('/inside/related');

    //加了这个之后就选不中下拉的li了
    /* $('.search_out').focusout(function(){
        $('.search_tip').css('display','none');
    }) */ 
    
	$("#corr").slider({ 
		range: true,
        min: -100,
        max: 100,
        values: [-100, 100 ],
        slide: function( event, ui ) {setSlider('corrs',ui,100,'','')},
    	stop: function() {
    		var arr = getData();
    		$('.investment_sec').css('display','block');
          	 $.get("/inside/related",{'result':arr['result'],'keyword':arr['key'],'inver':arr['inver']},
   	    	   function(data){ addArray(data); }
   	    	); 
    	}
    });

    function getData(){
        var arr = {};
    	//get the slider range value
        arr['result'] = getOneRange();
        var key = $('.search_newname').val();
        if(!key)return false;
        arr['key'] = $.trim(key.replace(/-.*/ig,''));
        //get the inverse and leverage checkbox
        arr['inver'] = getInverse();
        return arr;
    }

	//order by title desc or asc
	$('.sortClass th').click(function(){
	    if($(this).html()=='Select')return false;
	    //judge the table is empty or not
	    if($('.ajaxTable').html()=='') return false;
	    var order = fixOrder($(this));
	    //get the title
	    var key = $(this).html();
	    var arr = getData();
	    $.get("/inside/related",{'result':arr['result'],'keyword':arr['key'],'inver':arr['inver'],'key':key,'order':order},
		   function(data){addArray(data);}
		);
	});
});

function getOneRange(){
	var arr = {};
    arr['from'] = $('.min-item').html();
    arr['to'] = $('.max-item').html();
    return arr;
}
</script>