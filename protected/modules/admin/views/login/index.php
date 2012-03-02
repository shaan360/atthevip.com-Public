<?php echo CHtml::beginForm('', 'post', array('class' => 'styled')); ?>

	<!-- Username Field -->
	<label for="AdminLogin_email">
		<span>Email</span>
		<?php echo CHtml::activeTextField($form, 'email', array('class' => 'textbox')); ?>
		<?php echo CHtml::error($form, 'email'); ?>
	</label>
	
	<!-- Password Field -->
	<label for="AdminLogin_password">
		<span>Password</span>
		<?php echo CHtml::activePasswordField($form, 'password', array('class' => 'textbox')); ?>
		<?php echo CHtml::error($form, 'password'); ?>
	</label>
	
	<!-- Login button with custom CSS classes -->
	<input class="button red small" type="submit" value="Login" />
	
<?php echo CHtml::endForm(); ?>