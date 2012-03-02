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
				
				<label for="<?php echo get_class($model) . '_settingkey'; ?>">
					<span><?php echo $model->getAttributeLabel('settingkey'); ?></span>
					<?php echo CHtml::activeTextField($model, 'settingkey', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'settingkey', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_category'; ?>">
					<span><?php echo $model->getAttributeLabel('category'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'category', Settings::model()->getGroups(), array( 'prompt' => Yii::t('admin', '-- Choose Value --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'category', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_type'; ?>">
					<span><?php echo $model->getAttributeLabel('type'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'type', Settings::model()->getTypes(), array( 'prompt' => Yii::t('admin', '-- Choose Value --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'type', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_default_value'; ?>">
					<span><?php echo $model->getAttributeLabel('default_value'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'default_value', array( 'class' => 'textarea' )); ?>
					<?php echo CHtml::error($model, 'default_value', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_value'; ?>">
					<span><?php echo $model->getAttributeLabel('value'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'value', array( 'class' => 'textarea' )); ?>
					<?php echo CHtml::error($model, 'value', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_extra'; ?>">
					<span><?php echo $model->getAttributeLabel('extra'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'extra', array( 'class' => 'textarea' )); ?>
					<?php echo CHtml::error($model, 'extra', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_php'; ?>">
					<span><?php echo $model->getAttributeLabel('php'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'php', array( 'class' => 'textarea' )); ?>
					<?php echo CHtml::error($model, 'php', array( 'class' => 'input-error' )); ?>
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
