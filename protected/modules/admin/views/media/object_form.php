<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('media', 'Media Manager'), array('media/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Rackspace Files'), array('media/rackspace'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo $label; ?></h2>
			<div class="content">
		
				<?php echo CHtml::form(null, 'post', array('class' => 'styled', 'enctype'=>'multipart/form-data')); ?>
				<fieldset>
				
				<label for="<?php echo get_class($model) . '_is_active'; ?>">
					<span><?php echo $model->getAttributeLabel('is_active'); ?></span>
					<?php echo CHtml::activeCheckBox($model, 'is_active', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'is_active', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_container_id'; ?>">
					<span><?php echo $model->getAttributeLabel('container_id'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'container_id', CHtml::listData(MediaContainer::model()->findAll(), 'id', 'name'), array( 'prompt' => Yii::t('admin', '-- Choose Container --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'container_id', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_file'; ?>">
					<span><?php echo $model->getAttributeLabel('file'); ?></span>
					<?php echo CHtml::activeFileField($model, 'file', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'file', array( 'class' => 'input-error' )); ?>
				</label>
				
				<!-- Buttons -->
				<div class="non-label-section">
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right')); ?>
					<span><?php echo CHtml::link('Cancel', array('media/rackspace'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>
