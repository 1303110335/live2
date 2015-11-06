<?php $this->header('Screener By Issuer','Screen our ETF universe using asset class investment strategy and further
     refine results by various criteria and keywords','',false);?>

<div class="etf_found_sec_cont"><h2>Found <span class="fundNumber">0</span> of <span><?php echo $this->totalETFs();?></span> ETFs</h2></div>

<div class="issuer_box">
    <div class="issuer_menu menu2" style="height: 476px;">
        <div class="box box1" style="width:260px;display:block;">
            <ul >
            <?php foreach($result as $row){?>
                <li><?php echo $row->issuer;?></li>
            <?php }?>
            </ul>
            <div class="seeAllIssuer">See All Issuers</div>
        </div>
        
        <ul class="box box2" style="width:100px;">
            <?php foreach($result2 as $row){?>
                <li style="height:28px;"><?php echo $row->name;?></li>
            <?php }?>
        </ul>
        
        <ul class="box box3" style="width:213.8px;">
        </ul>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('.market_beta_cont_left').css('margin','20px 0 0 10px');

        $('.box1 li').click(function(){
            $('.box1 li').css('background','#DBDBDB').removeClass('issuer');
            $('.box2 li').css('background','#DBDBDB').removeClass('issuer2');
            $(this).addClass('issuer').css('background','#95BCF2');
            var issuer = $(this).html();
            $.post("/inside/issuer",{'issu':issuer},
          	   function(data){fillData(data);}
          	);
        });

        $('.box2 li').click(function(){
        	$('.box2 li').css('background','#DBDBDB').removeClass('issuer2');
            $(this).addClass('issuer2').css('background','#95BCF2');
            var name = $(this).html();
            var issuer = $.trim($('.issuer').html());
            $.post("/inside/issuer",{'name':name,'issuer':issuer},
          	   function(data){fillData(data);}
          	);
        });
    });

    /*fillData->live2*/
    
</script>

<?php $this->renderPartial('/common/investments');?>
