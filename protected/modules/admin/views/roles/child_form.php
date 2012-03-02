<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/management', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('roles', 'Roles'), array('roles/index'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo $label; ?></h2>
			<div class="content">
		
				<?php echo CHtml::form(null, 'post', array('class' => 'styled')); ?>
				<fieldset>
				

				<label for="<?php echo get_class($model) . '_parent'; ?>">
					<span><?php echo $model->getAttributeLabel('parent'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'parent', $roles, array('class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'parent', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_child'; ?>">
					<span><?php echo $model->getAttributeLabel('child'); ?></span>
					<?php echo CHtml::activeListBox($model, 'child', $roles, array('multiple' => 'multiple', 'class' => '', 'size' => 20 )); ?>
					<?php echo CHtml::error($model, 'child', array( 'class' => 'input-error' )); ?>
				</label>

				
				<!-- Buttons -->
				<div class="non-label-section">
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right')); ?>
					<span><?php echo CHtml::link('Cancel', array('roles/index'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>
