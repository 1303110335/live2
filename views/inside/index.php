<!-- show the table of ETFS -->
<?php $this->renderPartial('/common/overviewajax');?>

<div class="footnotes">
    <h4>Footnotes</h4>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies eget ante vel consectetur. Nam cursus justo ipsum, vitae these
        convallis ex viverra sed. Vivamus varius erat id elit blandit, ac sagittis leo vestibulum. Nam a rutrum urna. Fusce fermentum sit sarti
        amet purus eu vehicula. Pellentesque pretium volutpat vulputate.
    </p>
</div>



<script type="text/javascript">
$(function(){
	var url = window.location.search;
    var sql = url.substring(5, url.length);
    $.get("/inside/index",{'sqls':sql},
 	    function(data){  addArray(data);  }
 	);

   $('.investment_sec').css('display','block');

   //order by title desc or asc
	$('.sortClass th').click(function(){
	    if($(this).html()=='Select')return false;
	    //judge the table is empty or not
	    if($('.ajaxTable').html()=='') return false;
	    var order = fixOrder($(this));
	    //get the title
	    var key = $(this).html();
	    $.get("/inside/index",{'key':key,'order':order,'sqls':sql},
		   function(data){addArray(data);}
		);
	});
});

</script>


