<!-- iShare Sec -->
<div class="ishare_sec">
    <div class="ishare_sec_cont">
        <div class="ivv_heading">
            <div class="ivv_heading_block">
                <h3><?php if(isset($res->ticker))echo $res->ticker;else echo 'no ticker';?></h3>
            </div>
            <h2><?php if(isset($res->fullName))echo $res->fullName;else echo 'no fullName';?></h2>
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
                        <h3 class="last"></h3>
                    </td>
                    <td>
                        <p>Change (% Chg)</p>
                        <h3 class="change"></h3>
                    </td>
                    <td class="last_cell">
                        <table id="subtable">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Previous</p>
                                        <h3 class="grey previous"></h3>
                                    </td>
                                    <td>
                                        <p>Day's High</p>
                                        <h3 class="green high"></h3>
                                    </td>
                                    <td>
                                        <p>Volume</p>
                                        <h3 class="grey volume">4.2M Shares</h3>
                                    </td>
                                    <td>
                                        <p>52-Week High</p>
                                        <h3 class="grey week52high"></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Open</p>
                                        <h3 class="grey open"></h3>
                                    </td>
                                    <td>
                                        <p>Day's Low</p>
                                        <h3 class="red low"></h3>
                                    </td>
                                    <td>
                                        <p>Average Volume</p>
                                        <h3 class="grey averagevolume">4.2M Shares</h3>
                                    </td>
                                    <td>
                                        <p>52-Week Low</p>
                                        <h3 class="grey week52low"></h3>
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
                        <h3 class="last"></h3>
                    </td>
                    <td>
                        <p>Change (% Chg)</p>
                        <h3 class="change"></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Previous</p>
                        <h3 class="grey previous"></h3>
                    </td>
                    <td>
                        <p>Open</p>
                        <h3 class="grey open"></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Day's High</p>
                        <h3 class="grey high"></h3>
                    </td>
                    <td>
                        <p>Day's Low</p>
                        <h3 class="grey low"></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Volume</p>
                        <h3 class="grey volume">4.2M Shares</h3>
                    </td>
                    <td>
                        <p>Average Volume</p>
                        <h3 class="grey averagevolume">4.2M Shares</h3>

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>52-Week High</p>
                        <h3 class="grey week52high"></h3>
                    </td>
                    <td>
                        <p>52-Week Low</p>
                        <h3 class="grey low"></h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $.get('/inside/fundviewer',{'ishare':tickerName},
        	    function(data){addDataToIshare(data);}
        );
    });

    function addDataToIshare(data){
        if(data){
            data = $.parseJSON(data);
            $('.last').html(data.Last);
            $('.change').html(data.Change+'('+data.percent+' %)');
            $('.previous').html(data.Previous);
            $('.open').html(data.Open);
            $('.high').html(data.High);
            $('.low').html(data.Low);
            $('.averagevolume').html(data.AverageVolume/1000+'M Shares');
            $('.volume').html(data.Volume/1000+'M Shares');
            $('.week52high').html(data.Week52High);
            $('.week52low').html(data.Week52Low);
        }
    }
    
</script>
