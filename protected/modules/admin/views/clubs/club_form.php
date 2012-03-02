<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('clubs', 'clubs Manager'), array('clubs/index'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

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
				
				<label for="<?php echo get_class($model) . '_is_public'; ?>">
					<span><?php echo $model->getAttributeLabel('is_public'); ?></span>
					<?php echo CHtml::activeCheckBox($model, 'is_public', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'is_public', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_location'; ?>">
					<span><?php echo $model->getAttributeLabel('location'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'location', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'location', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_contact_info'; ?>">
					<span><?php echo $model->getAttributeLabel('contact_info'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'contact_info', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'contact_info', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_images'; ?>">
					<span><?php echo $model->getAttributeLabel('images'); ?></span>
					<div><small><?php echo Yii::t('admin', 'One image link per line'); ?></small></div>
					<?php echo CHtml::activeTextArea($model, 'images', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'images', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_video'; ?>">
					<span><?php echo $model->getAttributeLabel('video'); ?></span>
					<div><small><?php echo Yii::t('admin', 'Paste embed code'); ?></small></div>
					<?php echo CHtml::activeTextArea($model, 'video', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'video', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_description'; ?>">
					<span><?php echo $model->getAttributeLabel('description'); ?></span>
					<?php echo CHtml::error($model, 'description', array( 'class' => 'input-error' )); ?>
					<div>
						<?php $this->widget('application.widgets.ckeditor.CKEditor', array( 'model' => $model, 'attribute' => 'description', 'editorTemplate' => 'full' )); ?>
					</div>
					<?php echo CHtml::error($model, 'description', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_importer_file'; ?>">
					<span><?php echo $model->getAttributeLabel('importer_file'); ?></span>
					<div><small><?php echo Yii::t('admin', 'Should be located under protected/commands/ and following the naming convetion <name>Command.php'); ?></small></div>
					<?php echo CHtml::activeTextField($model, 'importer_file', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'importer_file', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_website'; ?>">
					<span><?php echo $model->getAttributeLabel('website'); ?></span>
					<?php echo CHtml::activeTextField($model, 'website', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'website', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_facebook'; ?>">
					<span><?php echo $model->getAttributeLabel('facebook'); ?></span>
					<div><small><?php echo Yii::t('admin', 'Club facebook account page'); ?></small></div>
					<?php echo CHtml::activeTextField($model, 'facebook', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'facebook', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_twitter'; ?>">
					<span><?php echo $model->getAttributeLabel('twitter'); ?></span>
					<div><small><?php echo Yii::t('admin', 'Club twitter account name'); ?></small></div>
					<?php echo CHtml::activeTextField($model, 'twitter', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'twitter', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_logo'; ?>">
					<span><?php echo $model->getAttributeLabel('logo'); ?></span>
					<div><small><?php echo Yii::t('admin', 'Club logo image url'); ?></small></div>
					<?php echo CHtml::activeTextField($model, 'logo', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'logo', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_watermark'; ?>">
					<span><?php echo $model->getAttributeLabel('watermark'); ?></span>
					<div><small><?php echo Yii::t('admin', 'Club watermark image URL'); ?></small></div>
					<?php echo CHtml::activeTextField($model, 'watermark', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'watermark', array( 'class' => 'input-error' )); ?>
				</label>
				
				<!-- Buttons -->
				<div class="non-label-section">
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right')); ?>
					<span><?php echo CHtml::link('Cancel', array('clubs/rackspace'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>
