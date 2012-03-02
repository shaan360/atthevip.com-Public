<!--Main Section-->
<div class="col1">
 <!-- Left Section -->
	<div class="colheading1">
    	<h1><?php echo Yii::t('site', 'Contact Us'); ?></h1>
    </div>			
    <div class="blogdetail">
    
	<div class="clear"></div>
		
     <div class="content group">
     	
     	<?php if($sent): ?>
     		<h2><?php echo Yii::t('site', 'Thank You. Your message was sent.'); ?></h2>
		<?php else: ?>
			<p><?php echo Yii::t('contactus', 'Please fill all required fields and hit the submit button once your done.'); ?></p>
     	
	     	<?php if($model->hasErrors()): ?>
			<div class="errordiv">
				<?php echo CHtml::errorSummary($model); ?>
			</div>
			<?php endif; ?>
	     	
	     	<?php echo CHtml::beginForm('', 'post', array('class' => 'contact-form nolabel')); ?>
	     	
	     	<label for="<?php echo get_class($model) . '_name'; ?>"><?php echo $model->getAttributeLabel('name'); ?> <span>(required)</span></label>
			<?php echo CHtml::activeTextField($model, 'name', array('class' => 'form-input', 'required' => 'required')); ?>
	     	
	     	<label for="<?php echo get_class($model) . '_email'; ?>"><?php echo $model->getAttributeLabel('email'); ?> <span>(required)</span></label>
			<?php echo CHtml::activeTextField($model, 'email', array('class' => 'form-input', 'required' => 'required')); ?>
	     	
	     	<label for="<?php echo get_class($model) . '_phone'; ?>"><?php echo $model->getAttributeLabel('phone'); ?> <span>(optional)</span></label>
			<?php echo CHtml::activeTextField($model, 'phone', array('class' => 'form-input')); ?>
	     	
	     	<label for="<?php echo get_class($model) . '_subject'; ?>"><?php echo $model->getAttributeLabel('subject'); ?> <span>(required)</span></label>
			<?php echo CHtml::activeTextField($model, 'subject', array('class' => 'form-input', 'required' => 'required')); ?>
	     	
	     	<label for="<?php echo get_class($model) . '_message'; ?>"><?php echo $model->getAttributeLabel('message'); ?> <span>(required)</span></label>
			<?php echo CHtml::activeTextArea($model, 'message', array('class' => 'form-input', 'required' => 'required')); ?>
	     	
	     	<label for="<?php echo get_class($model) . '_verifyCode'; ?>"><?php echo $model->getAttributeLabel('verifyCode'); ?> <span>(required)</span></label>
			<?php echo CHtml::activeTextField($model, 'verifyCode', array('class' => 'form-input', 'required' => 'required')); ?>
	     	<?php $this->widget('CCaptcha'); ?>
	     	
	     	<br /><br />
	     	
	     	<input class="form-btn" type="submit" value="Send Message" />
	     	
	     	<?php echo CHtml::endForm(); ?>
		<?php endif; ?>
     	
     </div>
    
 	</div>
<div class="clear"></div>

<?php CSSFile('http://fonts.googleapis.com/css?family=Oswald'); ?>
<?php //CSSFile(themeUrl() . '/css/reset.css'); ?>
<?php CSSFile(themeUrl() . '/css/contact-dark.css'); ?>

<script>
	$(function(){
		if( $.browser.msie && $.browser.version <= 9 ) {
			$('html').addClass('ie');
			
			$('form.msgtop.nolabel').find('p').append('<span class="before"/>');
		}
		
		// add 'invalid' class when HTML5 form valiation fails
		if( !$.browser.firefox ) {
			$('form.contact-form').each(function(){
				$(this).find('input.form-input').bind('invalid', function(){
					$(this).addClass('invalid');
				});
			});
		}
	});
</script>