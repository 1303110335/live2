<div class="checkbox_list">
    <div class="checkbox_list_col">
        <input id="checkAll" type="checkbox" checked name="check" value="check1" />
        <label>All ETF's</label>
    </div>

    <?php foreach($checkModel as $key => $row){?>
    <?php if($key==4){echo '<div style="width:181px;height:28px;position:relative;float:left;"></div>';} ?>
    <div class="checkbox_list_col">
        <input type="checkbox" name="check" checked value="check2" class="subcheck" />
        <label><?php echo $row[0];?></label>
        <div class="checkbox_list_col_content">
            <ul>
                <?php foreach($row as $k=> $son){?>
                <?php if($k==0)continue;?>
                <li>
                    <input name="check" value="check1" checked type="checkbox">
                    <label><?php echo $son;?></label>
                    <div class="clr"></div>
                </li>
                <?php }?>
            </ul>
        </div>
    </div>
    <?php }?>
    <div class="clr"></div>
</div>

<script type="text/javascript">
//select all or not
$(function(){
    checkAll();
    checkToggle();

    //three status about the checkbox
    //判断二级check的状态
    $('.checkbox_list_col_content input[name=check]').click(function(){
        var check=0;
        var notCheck=0;
        $(this).parents('.checkbox_list_col_content').find('input[name=check]').each(function(){
        //judge all checked or all not checked or half
         if($(this).attr('checked')=='checked') check++;
         else notCheck++;
        });
         var object = $(this).parents('.checkbox_list_col');//checkbox_list_col
         var value = $.trim(object.children('label').html());
        if(check ==0 ) {
      	    object.children('.shaded-check').remove();
            object.prepend('<input type="checkbox" name="check" value="check2" class="subcheck" />');
        }
        if(notCheck == 0) {
     	    object.children('.shaded-check').remove();
            object.remove('.shaded-check').prepend('<input type="checkbox" name="check" checked value="check2" class="subcheck" />');
        }
        if(check!=0 && notCheck!=0 && object.children('input[name=check]').length>0) {
            object.children('input[name=check]').remove();
            object.prepend('<img class="shaded-check" src="/images/shaded_check.png" alt="Partial">');
        }  
        checkToggle();
        checkAllDetail();
    });

    //判断checkAll的状态
	 checkAllDetail(); 
});

function checkToggle(){
    $('.subcheck').click(function(){
	    if($(this).attr('checked')=='checked')
	        $(this).parent().find('input[name=check]').attr('checked',true);
	    else{
	    	$(this).parent().find('input[name=check]').removeAttr('checked');
	    }
    });
}

function checkAll(){
    $('#checkAll').click(function(){        
		if($('#checkAll').attr('checked')=='checked'){
		    $('.checkbox_list input[name=check]').attr('checked','checked');
		}else
			$('.checkbox_list input[name=check]').removeAttr('checked');
    });
}

function checkAllDetail(){
	$('.checkbox_list input[name=check]').click(function(){
        var check=0;
        var notCheck=0;
	    $('.checkbox_list input[name=check]').each(function(){
	    	if($(this).attr('checked')=='checked') check++;
	         else notCheck++;
	    });
	    var object = $('.checkbox_list div:first');
	    if(check==0){
		    $('.shaded-check').remove();
		    if($('#checkAll').length==0)object.prepend('<input type="checkbox" value="check1" name="check" id="checkAll">');
	    }
	    else if(notCheck==0){
	    	$('.shaded-check').remove();
		    if($('#checkAll').length==0)object.prepend('<input type="checkbox" checked value="check1" name="check" id="checkAll">');
	    }
	    else {
		    $('#checkAll').parent().prepend('<img class="shaded-check" src="/images/shaded_check.png" alt="Partial">');
		    $('#checkAll').remove();
	    }
	    checkAll();
	});
}
</script>