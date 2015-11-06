<!-- iShare Sec -->
<div class="ishare_sec">
    <div class="ishare_sec_cont">
        <div class="ivv_heading">
            <div class="ivv_heading_block">
                <h3><?php echo $res->ticker;?></h3>
            </div>
            <h2><?php echo $res->fullName;?></h2>
            <div class="clr"></div>
        </div>
        <div class="ishare_sec_pagination">
            <p id="etflive">ETFLive Category</p>
            <!-- <p><span>(1) US Stocks </span>> Large Cop</p> -->
            <?php 
            for($i=1;$i<6;$i++){
                $field = 'classification'.$i;
                if(!empty($res->$field)) {echo '<p><span>('.$i.')'.$res->$field.'</span></p>';}
            }?>
            <div class="clr"></div>
        </div>
        <table id="ishare_main_table" class="responsive"> 
            <tbody>
                <tr>
                    <td id="firstcol">
                        <p>Last</p>
                        <h3 class="last"><?php echo $summary->Last;?></h3>
                    </td>
                    <td>
                        <p>Change (% Chg)</p>
                        <h3 class="change"><?php echo $summary->Change;echo ' ('.$summary->percent.'%)';?></h3>
                    </td>
                    <td class="last_cell">
                        <table id="subtable">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Previous</p>
                                        <h3 class="grey"><?php echo $summary->Previous;?></h3>
                                    </td>
                                    <td>
                                        <p>Day's High</p>
                                        <h3 class="green"><?php echo $summary->High;?></h3>
                                    </td>
                                    <td>
                                        <p>Volume</p>
                                        <h3 class="grey"><?php echo ($summary->Volume)/1000;?>M Shares</h3>
                                    </td>
                                    <td>
                                        <p>52-Week High</p>
                                        <h3 class="grey"><?php echo $summary->Week52High;?></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Open</p>
                                        <h3 class="grey"><?php echo $summary->Open;?></h3>
                                    </td>
                                    <td>
                                        <p>Day's Low</p>
                                        <h3 class="red"><?php echo $summary->Low;?></h3>
                                    </td>
                                    <td>
                                        <p>Average Volume</p>
                                        <h3 class="grey"><?php echo ($summary->AverageVolume)/1000;?>M Shares</h3>
                                    </td>
                                    <td>
                                        <p>52-Week Low</p>
                                        <h3 class="grey"><?php echo $summary->Week52Low;?></h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table id="ishare_res">
            <tbody>
                <tr>
                    <td>
                        <p>Last</p>
                        <h3 class="last"><?php echo $summary->Last;?></h3>
                    </td>
                    <td>
                        <p>Change (% Chg)</p>
                        <h3 class="change"><?php echo $summary->Change;?></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Previous</p>
                        <h3 class="grey"><?php echo $summary->Previous;?></h3>
                    </td>
                    <td>
                        <p>Open</p>
                        <h3 class="grey"><?php echo $summary->Open;?></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Day's High</p>
                        <h3 class="grey"><?php echo $summary->High;?></h3>
                    </td>
                    <td>
                        <p>Day's Low</p>
                        <h3 class="grey"><?php echo $summary->Low;?></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Volume</p>
                        <h3 class="grey"><?php echo ($summary->Last)/1000;?>M Shares</h3>
                    </td>
                    <td>
                        <p>Average Volume</p>
                        <h3 class="grey">4.2M Shares</h3>

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>52-Week High</p>
                        <h3 class="grey"><?php echo $summary->Week52High;?></h3>
                    </td>
                    <td>
                        <p>52-Week Low</p>
                        <h3 class="grey"><?php echo $summary->Week52Low;?></h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    var url = window.location.search;
    alert(url);
    
     //$.get('inside/fundviewer',{});
</script>
