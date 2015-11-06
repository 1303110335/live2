  <div class="membership_sec">
    <div class="membership_sec_cont">
        <div class="membership_sec_cont_left">
        <?php $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'register-form',
        	'enableClientValidation'=>false,
        	'clientOptions'=>array(
        		'validateOnSubmit'=>true,
        	),
        )); ?>
        
        <?php
            if (Yii::app()->user->hasFlash('error')) {
                echo "register fail,here may have some problem";
            }else if(Yii::app()->user->hasFlash('success')){
                $this->redirect_message('register succeed', 'success', 2, Yii::app()->createUrl('/fundprofiles/login'));
            }
        ?>
            <h4>ETFLive AllAccess</h4>
            <h2>Membership</h2>

            <div class="membership_sec_cont_right dis_block">
                <ul>
                    <li>Unlock all areas of ETFLive, including expert tools & analysis</li>
                    <li>Unlimited downloads of weekly, monthly, quaterly and annual returns for all ETFs in our universe</li>
                    <li>Access and download our comprehensive ETFLive Report ( See <a href="#">Sample Report</a> ) for nearly all ETFs in our universe</li>
                    <li>Build, analyze and generate professional ETFLive Reports for your custom portfolios</li>
                </ul>
            </div>
        		<?php echo $form->textField($model,'emailaddress',array('placeholder'=>'Enter Email Address')); ?>
        		<?php echo $form->error($model,'emailaddress'); ?>
        		<?php echo $form->textField($model,'username',array('placeholder'=>'Create Username')); ?>
        		<?php echo $form->error($model,'username'); ?>
        		<?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password')); ?>
        		<?php echo $form->error($model,'password'); ?>
        		<?php echo $form->passwordField($model,'password2',array('placeholder'=>'Re-enter Password')); ?>
        		<?php echo $form->error($model,'password2'); ?>

            <div class="radio_button_sec">
                <p>I am an:</p>
                <div class="radio_options">
                    <?php echo $form->radioButtonList($model,'investortype',
                        array('individual'=>'Individual Investor','institutional'=>'Institutional Investor','other'=>'Other'),
                        array('template'=>'<div class="radio_options_col">{input} {label}</div>','separator'=>''));?>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="privacy">
        		  <?php echo $form->checkBox($model,'checkETF'); ?>
                  <?php echo $form->label($model,'checkETF'); ?>
                  <?php echo $form->error($model,'checkETF'); ?>
            </div>
            <div class="get_button">
                <?php echo CHtml::submitButton('Get ETFLive AllAccess Pass'); ?>
            </div>
       <?php $this->endWidget();?>
        </div>
        <div class="membership_sec_cont_right dis_none">
            <ul>
                <li>Unlock all areas of ETFLive, including expert tools & analysis</li>
                <li>Unlimited downloads of weekly, monthly, quaterly and annual returns for all ETFs in our universe</li>
                <li>Access and download our comprehensive ETFLive Report ( See <a href="#">Sample Report</a> ) for nearly all ETFs in our universe</li>
                <li>Build, analyze and generate professional ETFLive Reports for your custom portfolios</li>
            </ul>
        </div>
        <div class="clr"></div>
    </div>
</div>


