  <div class="membership_sec">
    <div class="membership_sec_cont">
        <div class="membership_sec_cont_left" style="width:65%;">
        <?php $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'login-form',
        	'enableClientValidation'=>false,
        	'clientOptions'=>array(
        		'validateOnSubmit'=>true,
        	),
        )); ?>
        
            <h2>ETFLive AllAccess Login</h2>

        		<?php echo $form->textField($model,'emailaddress',array('placeholder'=>'Enter Email Address')); ?>
        		<?php echo $form->error($model,'emailaddress'); ?>
        		<?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password')); ?>
        		<?php echo $form->error($model,'password'); ?>

            <div class="get_button" style="width: 60%; margin: auto;">
                <?php echo CHtml::submitButton('Login'); ?>
            </div>
       <?php $this->endWidget();?>
        </div>

        <!-- advertisement -->
        <div class="issuer_ad">
            <img src="/images/advertisement.png" alt="advertisement">
        </div>

        <div class="clr"></div>
    </div>
</div>


  <div class="membership_sec">
    <div class="membership_sec_cont">
        <div class="membership_sec_cont_left" style="width:65%;">
        <form action="/fundprofiles/sendEmail" method="post">
            <h2>Forget Password ?</h2>
                <p>If you have forgetten your password, enter your e-mail adress below to retrive an link</p>
                <p style="margin-bottom:10px;display:block;"> to reset your password .</p>
                
        		<input placeholder="Enter Email Address" name="emailaddress" type="text" class="email">
                <p style="color:red;display:none;">your email address is not correct!</p>
            <div class="get_button" style="width: 60%; margin: auto;">
                <input name="emailSubmit" value="Retrive Password" type="submit">
            </div>
        </form>
        </div>

        <!-- advertisement -->
        <div class="issuer_ad">
            <img src="/images/advertisement.png" alt="advertisement">
        </div>

        <div class="clr"></div>
    </div>
</div>

<script type="text/javascript">
$('.email').focusout(function(){
    var filter = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
	var mail = $(this).val();
    if(!filter.test(mail)){
        $('.email').next().css('display','block');
        $('input[name=emailSubmit]').attr('disabled',true);	
    }else{
        $('.email').next().css('display','none');
        $('input[name=emailSubmit]').attr('disabled',false);
    }
});
</script>

