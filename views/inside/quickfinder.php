<?php $this->header('Quick Finder','Screen our ETF universe using asset class investment strategy and further refine results by various criteria and keywords');?>

<div class="main_cont" style="border:2px solid #cbcdcc;">
    <div class="checkbox_list">
        <?php foreach($checkModel as $key => $row){?>
        <div class="checkbox_list_col" style="width:22%">
            <?php if($row->name=='U. S. Stocks'){echo '<input class="check2" type="radio" name="check" checked value="'.$row->id.'" />';}
                else echo '<input class="check2" type="radio" name="check" value="'.$row->id.'" />';
            ?>
            <label><?php echo $row->name;?></label>
        </div>
        <?php }?>
        <div class="clr"></div>
    </div>
</div>

<div class="menu2" >
    <ul style="display: block;" class="box menu21">
        <li value="9">Equity Income</li>
        <li value="10">Style Box</li>
        <li value="11">Sector</li>
        <li value="151">Event-Driven</li>
    </ul>
    <ul class="box menu22">
    	<li>Equity Income</li>
    	<li>Style Box</li>
    	<li>Sector</li>
    </ul>
    <ul class="box special">
    	<li>ETF1</li>
    	<li>ETF2</li>
    	<li>ETF3</li>
    </ul>
    <div class="clearfix"></div>
</div>

<!-- start -->
<?php $this->renderPartial('/common/investments');?>
<!-- end -->

<script type="text/javascript" src="/js/etf/quickFinder.js"></script>




