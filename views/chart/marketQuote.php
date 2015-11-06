<?php $this->header('Quotes & Charting','Quickly review prevailing trading prices for any ETF
    along with trading prices for its top 10 holdings','Market Quote');?>

<?php $this->renderPartial('/common/iShare',array('res'=>$res));?>

<h1 style="font-size:xx-large;color:rgb(54,95,145)">Top 10 Holdings</h1>
<div class="marketBox">
     <div id="investment_left_list" class="left_list_sec" style="width:15%;">
        <div class="left_list_sec_block">
            <h3>Profile</h3>
            <ul>
                <li class="summaryUrl"><a href="#">Summary Sheet</a></li>
                <li><a href="#">Issuer Fact Sheet</a></li>
                <li><a href="#">Related ETF's</a></li>
            </ul>
        </div>
        <div class="left_list_sec_block">
            <h3>Quote & Analysis</h3>
            <ul>
                <li><a href="#">Market Quote</a></li>
                <li><a href="#">Advanced Charls</a></li>
                <li><a href="#">Historic Returns</a></li>
                <li><a href="#">Seasonality Chart</a></li>
            </ul>
        </div>
        <div class="left_list_sec_block">
            <h3>Statistical Tools</h3>
            <ul>
                <li><a href="#">Daily Returns</a></li>
                <li><a href="#">Market Beta</a></li>
                <li><a href="#">Volatility Chart</a></li>
                <li><a href="#">Correlation Chart</a></li>
                <li><a href="#">Spread Trade Analysis</a></li>
            </ul>
        </div>
        <div class="left_list_sec_block">
            <h3>Portfolio</h3>
            <ul>
                <li><a href="#">Add to Portfolio</a></li>
            </ul>
        </div>
    </div>

    <!-- Top 10 Holdings -->
    <div class="keyfacts_cont table_spe" style="width: 53%;margin: 0 10px;float: left;">
        <table>
            <thead>
                <tr class="odd">
                    <th>Company</th>
                    <th>Ticker</th>
                    <th>Weight(%)</th>
                </tr>
            </thead>
            <tbody class="holdingsTable">
            <?php $flag = false;?>
            <?php foreach($holdings as $row){?>
            <?php if(empty($row['company']))continue;?>
            <?php if($flag==true) {echo '<tr class="odd">';}else {echo '<tr>';}?>
                    <td><?php echo $row['company'];?></td>
                    <td><?php echo $row['ticker'];?></td>
                    <td><?php echo $row['weight']?></td>
                </tr>
            <?php $flag=!$flag;}?>
            </tbody>
        </table>    
        <!-- <a class="allHoldings" href="javascript:void(0)" style="margin-left: 570px;">See All Holdings</a> -->
    </div>

    <!-- advertisement -->
    <div class="market_beta_cont_right"><img src="/images/advertisement.png" alt="advertisement"></div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
    $('#investment_left_list').css('display','block');
</script>