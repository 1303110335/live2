<div class="search_out">
    <div class="search_new search_spe">
        <input class="search_newname" name="search" type="text" value="" placeholder="Enter Ticket or Keyword" />
    </div>
    <ul class="search_tip"></ul>
</div>

<script type="text/javascript">
function showTickers($url){
	$('.search_newname').keyup(function(){
        var key = $(this).val();
        if(key=='') {return false;}
    	$.ajax({
    	   type: "POST",
    	   url: $url,
    	   datatype:'html',
    	   data:{'search':key},
    	   success: function(data){
    		   $('.search_tip').empty().append(data);
    		   $('.search_tip li').click(function(){
       		       $('.search_newname').val($(this).html());
       		       $('.search_tip').css('display','none');
       		       return false;
       		   });
    	   }
    	});
        $('.search_tip').css('display','block');
    });
}
</script>