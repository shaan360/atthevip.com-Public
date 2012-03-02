<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/system', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo $label; ?></h2>
			<div class="content">
		
				<?php echo CHtml::form(null, 'post', array('class' => 'styled')); ?>
				<fieldset>
				
				<label for="<?php echo get_class($model) . '_title'; ?>">
					<span><?php echo $model->getAttributeLabel('title'); ?></span>
					<?php echo CHtml::activeTextField($model, 'title', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'title', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_description'; ?>">
					<span><?php echo $model->getAttributeLabel('description'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'description', array( 'class' => 'textarea' )); ?>
					<?php echo CHtml::error($model, 'description', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_groupkey'; ?>">
					<span><?php echo $model->getAttributeLabel('groupkey'); ?></span>
					<?php echo CHtml::activeTextField($model, 'groupkey', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'groupkey', array( 'class' => 'input-error' )); ?>
				</label>
				
				<!-- Buttons -->
				<div class="non-label-section">
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right')); ?>
					<span><?php echo CHtml::link('Cancel', array('settings/index'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>
