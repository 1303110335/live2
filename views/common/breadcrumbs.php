<div class="below_banner_sec">
        <div class="below_banner_sec_shadow"></div>
        <div class="pagination">
            <a href="/fundprofiles/index">Home</a> > <a href="#"><?php echo $title;?></a>
<?php if(isset($title2))echo ' > ' . $title2;?>
            </div></div><h1 class="breadH1">
<?php   if(isset($title2))echo $title2; else echo $title;?>
            </h1><div class="breadContent"><?php echo $content;?></div>
            
            
<?php /*$this->renderPartial('/common/breadcrumbs',array('title'=>'Holdings Screener',
    'content'=>'Find all ETFs with specified threshold positions in selected holding',
    'flag'=>true,
    'total'=>$this->totalETFs()
));*/?>

