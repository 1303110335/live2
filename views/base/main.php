<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ETF LIVE</title>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/slicknav.css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.min.js"></script>
<link href='<?php echo Yii::app()->request->baseUrl; ?>/css/family.css' rel='stylesheet' type='text/css' />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.2.min.js"></script>
<script src="/js/etf/main.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="header">
        	<div class="logo_sec"><a href="/Fundprofiles/index"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="ETFLIVE"  /></a></div>
            <div class="header_right">
                <div class="header_right_top">
                    <div class="header_right_social_icons">
                        <ul>
                            <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fb.png" alt="Facebook"/></a></li>
                            <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/twitter.png" alt="Twitter" /></a></li>
                            <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/gplus.png" alt="Google+" /></a></li>
                            <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/in.png" alt="Facebook" /></a></li>
                        </ul>
                    </div>
                    <div class="header_right_menu">
                    <?php if(Yii::app()->user->isGuest){?>
                        <ul class="guest">
                            <li><a href="/Fundprofiles/pass">Pricing</a></li>
                            <li><a href="/Fundprofiles/register">Free Signup</a></li>
                            <li id="login"><a href="/Fundprofiles/login">Login</a>
                                <div class="login_form">
                                    <div class="pointer_arrow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login_form_arrow.png" alt="Login" /></div>
                                    <div class="login_form_cont">
                                        <div class="membership_heading">
                                            <h4>ETFLive AllAccess</h4>
                                            <h2>Membership Login</h2>
                                        </div>
                                        <input name="emailaddress" placeholder="Enter Email Address" type="text"/>
                                        <input type="text" name="password" placeholder="Password" />
                                        <div class="errors"></div>
                                        <div class="login_button"><a href="javascript:;">Login</a></div>
                                        <p><a href="/Fundprofiles/login">Forgot Password?</a></p>
                                        <div class="clr"></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    <?php }else{?>
                        <ul class="admin">
                            <li><a href="#"><?php echo Yii::app()->session["username"];?></a></li>
                            <li><a href="/Fundprofiles/logout">Logout</a></li>
                            <li><a href="#">profile</a></li>
                        </ul>
                    <?php }?>
                    </div>
                    <div class="clr"></div>
                </div>

                <div class="search_bar">
                    <div class="search_bar_res">
                        <div class="search_res_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/search-icon-res.png" alt="Search" /></div>
                        <div class="search_res_cont"><input name="Search" type="text" value="" placeholder="Enter Ticket or Keyword" /></div>
                    </div>

                    <div class="user_bar_res">
                        <div class="user_res_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/user.png" alt="User" /></div>
                        <div class="user_res_cont"></div>
                    </div>

                    <div class="share_bar_res">
                        <div class="share_res_icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/share2.png" alt="Share" /></div>
                        <div class="share_res_cont">
                            <ul>
                                <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fb.png" alt="Facebook" /></a></li>
                                <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/twitter.png" alt="Twitter" /></a></li>
                                <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/gplus.png" alt="Google+" /></a></li>
                                <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/in.png" alt="Facebook" /></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clr"></div>
                    <form action="/Fundprofiles/search" method="post" name="research">
                        <input id="search_name" name="search" type="text" value="" placeholder="Enter Ticket or Keyword" />
                        <div class="search_bar_icon">
                            <input type="button" value="" 
                            style="background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/search-icon.png) no-repeat"/>
                        </div>
                        <ul class="search_tips" style="width:415px;left:6px;top:93px;">
                        </ul>
                    </form>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        
        <div class="menu_bar">
            <ul id="menu">
                <li id="etf-univ-menu">
                    ETF Universe
                    <div class="black_arrow"><img src="/images/black-arrow.png" alt="Pointer" /></div>
                    <?php echo $this->submenu1; ?>
                </li>
                <?php echo $this->other ;?>
            </ul>
        </div> 
        
        <?php echo $content;?>
        
        <div class="top"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/top.png" /></a></div>
        
        <div class="footer">
        <?php echo $this->footer;?>

            <div class="clr"></div>

            <div class="footer_bar">
                <p>Live Financial Technologies LLC 2015</p>
                <div class="footer_bar_social">
                    <p>Connect With Us:</p>
                    <ul>
                        <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fb.png" alt="Facebook" /></a></li>
                        <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/twitter.png" alt="Twitter" /></a></li>
                        <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/gplus.png" alt="Google+" /></a></li>
                        <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/in.png" alt="Facebook" /></a></li>
                    </ul>

                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
            </div>
        </div>    

        </div>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.slicknav.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#menu').slicknav();
        });
    </script>
    <script>
        $(".search_res_icon").click(function () {
            $(".search_res_cont").slideToggle("fast");
            $(".user_res_cont").slideUp("fast");
            $(".share_res_cont").slideUp("fast");
        });
        $(".user_res_icon").click(function () {
            $(".user_res_cont").slideToggle("fast");
            $(".search_res_cont").slideUp("fast");
            $(".share_res_cont").slideUp("fast");
        });
        $(".share_res_icon").click(function () {
            $(".share_res_cont").slideToggle("fast");
            $(".user_res_cont").slideUp("fast");
            $(".search_res_cont").slideUp("fast");
        });
    </script>

  
</body>

</html>