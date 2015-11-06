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
        
        <?php
            if(Yii::app()->user->hasFlash('success')){
                $this->redirect_message('ResetPassword succeed', 'success', 2, Yii::app()->createUrl('/fundprofiles/login'));
            }
        ?>
            <h2>Reset Your Password</h2>

    		<?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password')); ?>
    		<?php echo $form->error($model,'password'); ?>
            <?php echo $form->passwordField($model,'password2',array('placeholder'=>'Enter rePassword')); ?>
    		<?php echo $form->error($model,'password2'); ?>
            <div class="get_button" style="width: 60%; margin: auto;">
                <?php echo CHtml::submitButton('Reset'); ?>
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




