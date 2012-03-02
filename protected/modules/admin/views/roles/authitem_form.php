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
				
				<label for="<?php echo get_class($model) . '_name'; ?>">
					<span><?php echo $model->getAttributeLabel('name'); ?></span>
					<?php echo CHtml::activeTextField($model, 'name', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'name', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_description'; ?>">
					<span><?php echo $model->getAttributeLabel('description'); ?></span>
					<?php echo CHtml::activeTextField($model, 'description', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'description', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_type'; ?>">
					<span><?php echo $model->getAttributeLabel('type'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'type', AuthItem::model()->types, array('class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'type', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_bizrule'; ?>">
					<span><?php echo $model->getAttributeLabel('bizrule'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'bizrule', array( 'class' => 'textarea' )); ?>
					<?php echo CHtml::error($model, 'bizrule', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_data'; ?>">
					<span><?php echo $model->getAttributeLabel('data'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'data', array( 'class' => 'textarea' )); ?>
					<?php echo CHtml::error($model, 'data', array( 'class' => 'input-error' )); ?>
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