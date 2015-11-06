<?php $this->header('Screener By Index','Screen our ETF universe using asset class investment strategy and 
further refine results by various criteria and keywords','',false);?>

<div class="etf_found_sec_cont"><h2>Found <span class="fundNumber">0</span> of <span><?php echo $this->totalETFs();?></span> ETFs</h2></div>
<div class="issuer_box" style="margin: 10px 5px 0 0;">
    <div class="issuer_menu menu2" style="margin:0;">
        <ul class="box box1" style="width:301px;">
        <?php foreach($result as $row){?>
            <li><?php echo $row->indexName;?></li>
        <?php }?>
        </ul>
        
        <ul class="box box3" style="width:46%;"></ul>
    </div>
</div>

<script type="text/javascript">
    $('.box1 li').click(function(){
        $('.box1 li').css('background','#DBDBDB').removeClass('issuer');
        $(this).addClass('issuer').css('background','#95BCF2');
        var index = $(this).html();
        $.post("/inside/indexs",{'index':index},
      	   function(data){fillData(data);}
      	);
    });
    
    /*fillData->live2*/
</script>

<?php $this->renderPartial('/common/investments');?>
