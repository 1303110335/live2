<?php $this->header('Screener By Index Sponsor','Screen our ETF universe using asset class investment strategy and 
further refine results by various criteria and keywords','',false);?>

<div class="etf_found_sec_cont"><h2>Found <span class="fundNumber">0</span> of <span><?php echo $this->totalETFs();?></span> ETFs</h2></div>

<div class="issuer_box" style="margin: 10px 5px 0 0;">
    <div class="issuer_menu menu2" style="margin:0px;">
        <ul class="box box1" style="width:225px;">
        <?php foreach($result as $row){?>
            <li><?php echo $row->indexSponsor;?></li>
        <?php }?>
        </ul>
        <ul class="box box3" style="width:58%;"></ul>
    </div>
</div>

<script type="text/javascript">
    $('.box1 li').click(function(){
        $('.box1 li').css('background','#DBDBDB').removeClass('issuer');
        $(this).addClass('issuer').css('background','#95BCF2');
        var index = $(this).html();
        $.post("/inside/indexsponsor",{'index':index},
      	   function(data){fillData(data);}
      	);
    });
    
    /*fillData ->live2*/
</script>

<?php $this->renderPartial('/common/investments');?>
