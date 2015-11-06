<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//base/main'); ?>
<script>
    jQuery(document).ready(function () {
        jQuery('.tabs .tab-links a').on('click', function (e) {
            var currentAttrValue = jQuery(this).attr('href');
    
            // Show/Hide Tabs
            jQuery('.tabs ' + currentAttrValue).fadeIn(500).siblings().hide();
    
            // Change/remove current tab to active
            jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
    
            e.preventDefault();
        });
    });

</script>

<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/responsive-tables.css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/responsive-tables.js"></script>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/select.js'></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fancybox.css" media="screen" />
<script type="text/javascript">
    $(document).ready(function () {
        $("#various9").fancybox({
            'titlePosition': 'inside',
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
    });
</script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.accordion.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.accordion').accordion({ defaultOpen: '' });
    });
</script>


<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jslider.plastic.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.flexisel.js"></script>
<!-- content -->
<?php echo $content; ?>



<script>
    $(".double_arrow").click(function () {
        $("#menu2").slideToggle("fast");
        
    });
    $(".double_arrow2").click(function () {
        $("#menu3").slideToggle("fast");

    });
</script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/etf/live2.js"></script>

<script type="text/javascript">

$("#flexiselDemo3").flexisel({
    visibleItems: 4,
    animationSpeed: 200,
    autoPlay: false,
    autoPlaySpeed: 3000,
    pauseOnHover: true,
    enableResponsiveBreakpoints: true,
    responsiveBreakpoints: {   
        portrait: {
            changePoint: 340,
            visibleItems: 1
        },
        landscape: {
            changePoint: 420,
            visibleItems: 2
        }
    }
});
</script>
<?php $this->endContent(); ?>